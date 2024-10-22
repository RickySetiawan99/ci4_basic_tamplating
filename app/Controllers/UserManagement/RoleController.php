<?php

namespace App\Controllers\UserManagement;

use App\Controllers\BaseController;
use App\Models\GroupModel;

class RoleController extends BaseController
{
    private $title      = 'User Management | Role';
    private $route      = 'user-management/roles'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard'
    private $namespace  = 'user_management/roles/';
    private $header     = 'Role';
    private $sub_header = 'Role';
    private $modelName  = GroupModel::class;

    protected $model;

    protected static $protectedMethods = [
        // 'role-read'   => ['index', 'fetchData'],
        // 'role-create' => ['create', 'store'],
        // 'role-update' => ['edit', 'update'],
        // 'role-delete' => ['destroy'],
    ];

    public function __construct()
    {
        $this->model = new $this->modelName;
    }
    
    public function index()
    {
        $data = [
            'title'         => $this->title,
            'route'         => $this->route,
            'header'        => $this->header,
            'sub_header'    => $this->sub_header,
        ];
        
        return view($this->namespace.'index', $data);
    }

    public function fetchData()
    {
        $request = service('request');
        $roleModel = $this->model;

        // Ambil parameter dari inputan filter (misal: nama, email)
        $name       = $request->getPost('name');
        $start      = (int) $request->getPost('start');
        $length     = (int) $request->getPost('length');
        $draw       = $request->getPost('draw');

        $permissions = $roleModel->select('id, name');

        $totalRecords = $permissions->countAllResults(false);

        if (!empty($name)) {
            $permissions->like('name', $name);
        }

        $totalFiltered = $permissions->countAllResults(false);

        $data = $permissions->limit($length, $start)->get()->getResultArray();

        $formattedData = [];
        foreach ($data as $key => $value) {
            // Tambahkan nomor urut (index + 1 + $start) untuk memperhitungkan pagination
            $btnEdit    = '<a href="' . site_url($this->route.'/edit/' . encode_id($value['id'])) . '" class="btn btn-md btn-primary mx-1" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>';
            $btnDelete  = '<a href="javascript:;" data-route="' . site_url($this->route.'/destroy/' . encode_id($value['id'])) . '" class="btn btn-delete btn-md btn-danger mx-1" data-bs-toggle="tooltip" title="Delete" data-container="body" data-animation="true"><i class="fas fa-trash"></i></a>';
            
            $formattedData[] = [
                'no'            => $start + $key + 1, // Nomor urut
                'name'          => $value['name'],
                'action'        => $btnEdit.$btnDelete
            ];
        }

        $jsonData = [
            "draw"              => intval($draw),
            "recordsTotal"      => $totalRecords,
            "recordsFiltered"   => $totalFiltered,
            "data"              => $formattedData
        ];

        return $this->response->setJSON($jsonData);
    }

    public function create()
    {
        $data = [
            'title'         => $this->title,
            'route'         => $this->route,
            'header'        => $this->header,
            'sub_header'    => $this->sub_header,
            'route_back'    => base_url($this->route),
            'permissions'   => $this->authorize->permissions(),
        ];

        return view($this->namespace.'create', $data);
    }

    public function store()
    {
        $validationRules = [
            'name'        => 'required|max_length[255]|is_unique[auth_groups.name]',
            'description' => 'required|max_length[255]',
            'permission'  => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            $name           = $this->request->getPost('name');
            $description    = $this->request->getPost('description');
            $permission     = $this->request->getPost('permission');

            $id = $this->authorize->createGroup(url_title($name), $description);
            
            foreach ($permission as $value) {
                $this->authorize->addPermissionToGroup($value, $id);
            }

            $this->db->transCommit();

        } catch (\Throwable $e) {
            $this->db->transRollback();

            $message = $e->getMessage();
            return redirect()->back()->with('error', parsingAlert($message));
        }
        clear_cache();

        $message = 'Role created successfully!';
        return redirect()->to($this->route)->with('success', parsingAlert($message));
    }

    public function edit($role_id)
    {
        $id = decode_id($role_id)[0];

        $data = [
            'title'         => $this->title,
            'route'         => $this->route,
            'header'        => $this->header,
            'sub_header'    => $this->sub_header,
            'route_back'    => base_url($this->route),
            'data'          => $this->authorize->group($id),
            'permissions'   => $this->authorize->permissions(),
            'permission'    => $this->authorize->groupPermissions($id),
        ];

        return view($this->namespace.'update', $data);
    }

    public function update($role_id)
    {
        $id = decode_id($role_id)[0];

        $validationRules = [
            'name' => 'required',
            'description' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            // Ambil data dari request
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ];

            $groupModel = $this->model;
            $groupModel->save($data, $id);

            $permissions = $this->request->getPost('permission');
            // $this->db->table('auth_groups_permissions')->where('group_id', $id)->delete();
            $this->db->table('auth_groups_permissions')->where('group_id', $id)->delete();
            foreach ($permissions as $permission) {
                $this->authorize->addPermissionToGroup($permission, $id);
            }

            $this->db->transCommit();

        } catch (\Throwable $e) {
            $this->db->transRollback();

            $message = $e->getMessage();
            return redirect()->back()->with('error', parsingAlert($message));
        }
        clear_cache();

        $message = 'Role updated successfully!';
        return redirect()->to($this->route)->with('success', parsingAlert($message));
    }

    public function destroy($role_id)
    {
        $id = decode_id($role_id);

        $roleModel = $this->model;
        $permission = $roleModel->find($id);
        if ($permission) {
            // Hapus permission
            $roleModel->delete($id);

            clear_cache();
            return $this->response->setJSON([
                'status'    => true,
                'message'   => 'Permission deleted successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'status'    => false,
                'message'   => 'Failed to delete permission'
            ]);
        }
    }
}
