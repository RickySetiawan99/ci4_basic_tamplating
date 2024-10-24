<?php

namespace App\Controllers\UserManagement;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

class UserController extends BaseController
{
    private $title      = 'User Management | User';
    private $route      = 'user-management/users'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard'
    private $namespace  = 'user_management/users/';
    private $header     = 'User';
    private $sub_header = 'User';
    private $modelName  = UserModel::class;

    protected $model;

    protected static $protectedMethods = [
        'user-read'     => ['index', 'fetchData'],
        'user-create'   => ['create', 'store'],
        'user-update'   => ['edit', 'update'],
        'user-delete'   => ['destroy'],
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
        $request    = service('request');
        $userModel  = $this->model;
        $getData    = $userModel->select('id, username, email, created_at');
        $where      = [];
        $join       = [];
        $leftjoin   = [];
        
        // filter
        $filters = [
            'username'  => [$request->getPost('name'), 'like'],
            'email'     => [$request->getPost('email'), 'like'],
        ];
        foreach ($filters as $column => $value) {
            $param = $value[0];       // Nilai filter
            $operator = $value[1];    // Operator filter
            
            if (!empty($param)) {
                if ($operator === 'like') {
                    $getData->like($column, $param); // Gunakan 'like' untuk pencarian
                } else {
                    $getData->where($column, $operator, $param); // Gunakan operator lainnya
                }
            }
        }

        foreach ($where as $condition) {
            $getData->where($condition[0] . ' ' . $condition[1], $condition[2]);
        }
        foreach ($join as $joinCondition) {
            $type = $joinCondition[2] ?? 'INNER';
            $getData->join($joinCondition[0], $joinCondition[1], $type);
        }
        foreach ($leftjoin as $leftJoinCondition) {
            $getData->leftJoin($leftJoinCondition[0], $leftJoinCondition[1]);
        }

        // Ambil parameter pengurutan
        $orderColumnIndex   = $request->getPost('order')[0]['column']; // Indeks kolom yang diurutkan
        $orderDirection     = $request->getPost('order')[0]['dir']; // 'asc' atau 'desc'
        $columns            = ['id', 'username', 'email', 'created_at']; // Sesuaikan dengan nama kolom di database
        $orderColumn        = $columns[$orderColumnIndex]; // Nama kolom yang sesuai
        // Tambahkan pengurutan
        $getData->orderBy($orderColumn, $orderDirection);

        $totalRecords       = $getData->countAllResults(false);
        $totalFiltered      = $getData->countAllResults(false);
        $start              = (int) $request->getPost('start');
        $length             = (int) $request->getPost('length');
        $draw               = $request->getPost('draw');
        $data               = $getData->limit($length, $start)->get()->getResultArray();

        $formattedData = [];
        foreach ($data as $key => $value) {
            $btnEdit    = '<a href="' . site_url($this->route.'/edit/' . encode_id($value['id'])) . '" class="btn btn-md btn-primary mx-1" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>';
            $btnDelete  = '<a href="javascript:;" data-route="' . site_url($this->route.'/destroy/' . encode_id($value['id'])) . '" class="btn btn-delete btn-md btn-danger mx-1" data-bs-toggle="tooltip" title="Delete" data-container="body" data-animation="true"><i class="fas fa-trash"></i></a>';
            
            $formattedData[] = [
                'no'            => $start + $key + 1, // Nomor urut
                'username'      => $value['username'],
                'email'         => $value['email'],
                'created_at'    => $value['created_at'],
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
            'roles'         => $this->authorize->groups(),
        ];

        return view($this->namespace.'create', $data);
    }

    public function store()
    {
        $validationRules = [
            'active'       => 'required',
            'username'     => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required',
            'pass_confirm' => 'required|matches[password]',
            'permission'   => 'required',
            'role'         => 'required',
        ];

        $permissions = $this->request->getPost('permission');
        $roles = $this->request->getPost('role');

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            $id = $this->model->insert(new User([
                'active'   => $this->request->getPost('active'),
                'email'    => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password'),
            ]));

            foreach ($permissions as $permission) {
                $this->authorize->addPermissionToUser($permission, $id);
            }

            foreach ($roles as $role) {
                $this->authorize->addUserToGroup($id, $role);
            }

            $this->db->transCommit();
        } catch (\Exception $e) {
            $this->db->transRollback();

            $message = $e->getMessage();
            return redirect()->back()->with('error', parsingAlert($message));
        }

        $message = 'Data User saved succesfully';
        return redirect()->to(base_url($this->route))->with('success', parsingAlert($message));
    }

    public function edit($user_id)
    {
        $id = decode_id($user_id)[0];

        $data = [
            'title'         => $this->title,
            'route'         => $this->route,
            'header'        => $this->header,
            'sub_header'    => $this->sub_header,
            'route_back'    => base_url($this->route),
            'user'          => $this->model->find($id),
            'permissions'   => $this->authorize->permissions(),
            'permission'    => (new PermissionModel())->getPermissionsForUser($id),
            'roles'         => $this->authorize->groups(),
            'role'          => (new GroupModel())->getGroupsForUser($id),
        ];

        return view($this->namespace.'/update', $data);
    }

    public function update($user_id)
    {
        $id = decode_id($user_id)[0];

        // Fetch the current user data
        $currentUser = $this->model->find($id);

        // Prepare validation rules
        $validationRules = [
            'active'       => 'required',
            'username'     => [
                'rules'  => ($this->request->getPost('username') !== $currentUser->username) 
                            ? "required|alpha_numeric_space|min_length[3]|is_unique[users.username]" 
                            : "required|alpha_numeric_space|min_length[3]",
                'errors' => [
                    'is_unique' => 'The username is already taken.'
                ]
            ],
            'email'        => [
                'rules'  => ($this->request->getPost('email') !== $currentUser->email) 
                            ? "required|valid_email|is_unique[users.email]" 
                            : "required|valid_email",
                'errors' => [
                    'is_unique' => 'The email is already in use.'
                ]
            ],
            'password'     => 'if_exist',
            'pass_confirm' => 'matches[password]',
            'permission'   => 'required',
            'role'         => 'required',
        ];

        // Validate input data
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            $user = new User();

            // Check if the password is set
            if ($this->request->getPost('password')) {
                $user->password = $this->request->getPost('password');
            }

            // Update user data
            $user->active = $this->request->getPost('active');
            $user->email = $this->request->getPost('email');
            $user->username = $this->request->getPost('username');

            $this->model->skipValidation(true)->update($id, $user);

            // Update permissions and roles
            $this->db->table('auth_users_permissions')->where('user_id', $id)->delete();
            foreach ($this->request->getPost('permission') as $permission) {
                $this->authorize->addPermissionToUser($permission, $id);
            }

            $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
            foreach ($this->request->getPost('role') as $role) {
                $this->authorize->addUserToGroup($id, $role);
            }

            $this->db->transCommit();

        } catch (\Exception $e) {
            $this->db->transRollback();
            
            $message = $e->getMessage();
            return redirect()->back()->with('error', parsingAlert($message));
        }

        $message = 'Data User updated successfully';
        return redirect()->to(base_url($this->route))->with('success', parsingAlert($message));
    }

    public function destroy($user_id)
    {
        $id = decode_id($user_id);

        if ($this->model->delete($id)) {
            return $this->response->setJSON([
                'status'    => true,
                'message'   => 'User deleted successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'status'    => false,
                'message'   => 'Failed to delete user'
            ]);
        }
    }

    public function profile()
    {
        if ($this->request->getMethod() === 'POST') {
            $id = user()->id;
            $validationRules = [
                'email'        => "required|valid_email|is_unique[users.email,id,$id]",
                'username'     => "required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,$id]",
                'password'     => 'if_exist',
                'pass_confirm' => 'matches[password]',
            ];

            if (!$this->validate($validationRules)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }

            $user = new User();

            if ($this->request->getPost('password')) {
                $user->password = $this->request->getPost('password');
            }

            $user->email = $this->request->getPost('email');
            $user->username = $this->request->getPost('username');

            if ($this->model->skipValidation(true)->update(user()->id, $user)) {
                return redirect()->back()->with('success', 'Profile Updated');
            }

            return redirect()->back()->withInput()->with('error', 'Profile update failed');
        }

        $data = [
            'title'         => $this->title,
            'route'         => $this->route,
            'header'        => $this->header,
            'sub_header'    => $this->sub_header,
        ];

        return view($this->namespace.'/profile', $data);
    }
}
