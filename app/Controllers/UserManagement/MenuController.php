<?php

namespace App\Controllers\UserManagement;

use App\Controllers\BaseController;
use App\Entities\MenuEntity;
use App\Models\GroupMenuModel;
use App\Models\MenuModel;
use CodeIgniter\API\ResponseTrait;

class MenuController extends BaseController
{
    use ResponseTrait;

    private $title      = 'User Management | Menu';
    private $route      = 'user-management/menus'; //path awal foldernya ajah (misal folder di admin/dashboard) => 'admin.dashboard'
    private $namespace  = 'user_management/menus/';
    private $header     = 'Menu';
    private $sub_header = 'Menu';

    protected $menu;
    protected $groupsMenu;

    protected static $protectedMethods = [
        'menu-read'     => ['index'],
        'menu-create'   => ['new', 'create'],
        'menu-update'   => ['edit', 'update'],
        'menu-delete'   => ['delete'],
    ];

    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->groupsMenu = new GroupMenuModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return \CodeIgniter\View\View | \CodeIgniter\API\ResponseTrait
     */
    public function index()
    {
        $data = [
            'title'         => $this->title,
            'route'         => $this->route,
            'header'        => $this->header,
            'sub_header'    => $this->sub_header,
            'roles'    => $this->authorize->groups(),
            'menus'    => $this->menu->orderBy('sequence', 'asc')->findAll(),
        ];

        if ($this->request->isAJAX()) {
            return $this->respond(['data' => nestable()]);
        }

        return view($this->namespace.'index', $data);
    }

    /**
     * Update to sort menu.
     *
     * @return CodeIgniter\API\ResponseTrait
     */
    public function new()
    {
        $data = $this->request->getJSON();
        $menu = new MenuEntity();

        $this->db->transBegin();

        try {
            $i = 1;
            foreach ($data as $item) {
                if (isset($item->parent_id)) {
                    $menu->parent_id = $item->parent_id;
                    $menu->sequence = $i++;
                } else {
                    $menu->parent_id = 0;
                    $menu->sequence = $i++;
                }

                $this->menu->update($item->id, $menu);
            }

            $this->db->transCommit();
        } catch (\Exception $e) {
            $this->db->transRollback();

            return $this->fail('Menu tidak berhasil di urutkan.');
        }

        return $this->respondUpdated([], 'Menu berhasil dirubah.');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return \CodeIgniter\API\ResponseTrait
     */
    public function create()
    {
        $validationRules = [
            'parent_id'   => 'required|numeric',
            'active'      => 'required|numeric',
            'icon'        => 'required|min_length[5]|max_length[55]',
            'route'       => 'required|max_length[255]',
            'title'       => 'required|min_length[2]|max_length[255]',
            'groups_menu' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->db->transBegin();

        try {
            $menu = new MenuEntity();
            $menu->parent_id = $this->request->getPost('parent_id');
            $menu->active = $this->request->getPost('active');
            $menu->title = $this->request->getPost('title');
            $menu->icon = $this->request->getPost('icon');
            $menu->route = $this->request->getPost('route');
            $menu->sequence = $menu->sequence() + 1;

            $id = $this->menu->insert($menu);

            foreach ($this->request->getPost('groups_menu') as $groups) {
                $this->groupsMenu->insert([
                    'group_id' => $groups,
                    'menu_id'  => $id,
                ]);
            }

            $this->db->transCommit();
        } catch (\Exception $e) {
            $this->db->transRollback();

            return redirect()->back()->with('sweet-error', $e->getMessage());
        }

        return redirect()->back()->with('sweet-success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int id
     *
     * @return \CodeIgniter\API\ResponseTrait
     */
    public function update($id)
    {
        $validationRules = [
            'parent_id'   => 'required|numeric',
            'active'      => 'required|numeric',
            'icon'        => 'required|min_length[5]|max_length[55]',
            'route'       => 'required|max_length[255]',
            'title'       => 'required|min_length[2]|max_length[255]',
            'groups_menu' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = $this->request->getRawInput();

        $this->db->transBegin();

        try {
            $menu = $this->menu->update($id, [
                'parent_id' => $data['parent_id'],
                'active'    => $data['active'],
                'title'     => $data['title'],
                'icon'      => $data['icon'],
                'route'     => $data['route'],
            ]);

            // first remove all groups_menu by id
            $this->db->table('groups_menu')->where('menu_id', $id)->delete();

            foreach ($data['groups_menu'] as $groups) {
                // insert with new
                $this->groupsMenu->insert([
                    'group_id' => $groups,
                    'menu_id'  => $id,
                ]);
            }

            $this->db->transCommit();
        } catch (\Exception $e) {
            $this->db->transRollback();

            return $this->fail($e->getMessage());
        }

        return $this->respondUpdated($menu, 'Menu berhasil dirubah.');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int id
     *
     * @return \CodeIgniter\API\ResponseTrait
     */
    public function edit($id)
    {
        $found = $this->menu->getMenuById($id);

        if ($this->request->isAJAX()) {
            if (!$found) {
                return $this->failNotFound('Menu tidak ditemukan atau sudah dihapus.');
            }

            return $this->respond([
                'data'  => $found,
                'menu'  => $this->menu->getMenu(),
                'roles' => $this->menu->getRole(),
            ]);
        }
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int id
     *
     * @return \CodeIgniter\API\ResponseTrait
     */
    public function delete($id)
    {
        if (!$this->menu->delete($id)) {
            return $this->failNotFound('Menu tidak ditemukan atau sudah dihapus.');
        }

        return $this->respondDeleted(['id' => $id], 'Menu berhasil dihapus.');
    }
}
