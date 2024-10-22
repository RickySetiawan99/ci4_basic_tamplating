<?php

namespace App\Controllers\UserManagement;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class PermissionController extends BaseController
{
    private $title      = 'User Management | Permission';
    private $route      = 'user-management/permissions'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard'
    private $namespace  = 'user_management/permissions/';
    private $header     = 'Permission';
    private $sub_header = 'Permission';
    private $modelName  = PermissionModel::class;

    protected $model;

    protected static $protectedMethods = [
        'permission-read'   => ['index', 'fetchData'],
        'permission-create' => ['create', 'store'],
        'permission-update' => ['edit', 'update'],
        'permission-delete' => ['destroy'],
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
        $permissionModel = $this->model;

        // Ambil parameter dari inputan filter (misal: nama, email)
        $name       = $request->getPost('name');
        $start      = (int) $request->getPost('start');
        $length     = (int) $request->getPost('length');
        $draw       = $request->getPost('draw');

        $permissions = $permissionModel->select('id, name');

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
        ];

        return view($this->namespace.'create', $data);
    }

    public function store()
    {
        $validationRules = [
            'name'       => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            // Ambil data dari request
            $data = [
                'name' => $this->request->getPost('name'),
            ];

            $permissionModel = $this->model;
            $permissionModel->insert($data);

            $this->db->transCommit();

        } catch (\Throwable $e) {
            $this->db->transRollback();

            $message = $e->getMessage();
            return redirect()->back()->with('error', parsingAlert($message));
        }

        $message = 'Permission created successfully!';
        return redirect()->to($this->route)->with('success', parsingAlert($message));
    }

    public function edit($permission_id)
    {
        $id = decode_id($permission_id)[0];

        $data = [
            'title'         => $this->title,
            'route'         => $this->route,
            'header'        => $this->header,
            'sub_header'    => $this->sub_header,
            'route_back'    => base_url($this->route),
            'data'          => $this->model->find($id)
        ];

        return view($this->namespace.'update', $data);
    }

    public function update($permission_id)
    {
        $id = decode_id($permission_id)[0];

        $validationRules = [
            'name' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            // Ambil data dari request
            $data = [
                'name' => $this->request->getPost('name'),
            ];

            $permissionModel = $this->model;
            $permissionModel->update($id, $data);

            $this->db->transCommit();

        } catch (\Throwable $e) {
            $this->db->transRollback();

            $message = $e->getMessage();
            return redirect()->back()->with('error', parsingAlert($message));
        }

        $message = 'Permission updated successfully!';
        return redirect()->to($this->route)->with('success', parsingAlert($message));
    }

    public function destroy($permission_id)
    {
        $id = decode_id($permission_id);

        $permissionModel = $this->model;
        $permission = $permissionModel->find($id);
        if ($permission) {
            // Hapus permission
            $permissionModel->delete($id);

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
