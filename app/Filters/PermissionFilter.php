<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Mengambil instance dari authentication dan router
        $auth = service('authentication');
        $router = service('router');
        
        // Mendapatkan nama method (aksi) yang diakses
        $method = $router->methodName();

        // Ubah nama method menjadi lowercase dan pisahkan kata dengan underscore
        $method = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $method));
        
        // Mendapatkan nama controller tanpa namespace
        $controllerWithNamespace = $router->controllerName();
        $controller = basename(str_replace('\\', '/', $controllerWithNamespace)); // Hanya ambil nama class
        
        // Hilangkan kata 'Controller' jika ada
        $controller = str_replace('Controller', '', $controller);

        // Ubah nama controller menjadi lowercase dan pisahkan kata dengan underscore
        $controller = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $controller));
        
        // Gabungkan nama controller dan method dengan format 'controller-method'
        $permission = $controller . '-' . $method;

        // Cek apakah user sudah login
        if (!$auth->check()) {
            return redirect()->to('/login');
        }

         // Cek apakah method memerlukan permission
        if (class_exists($controllerWithNamespace) && method_exists($controllerWithNamespace, 'requiresPermission')) {
            if ($controllerWithNamespace::requiresPermission($method)) {
                // Jika memerlukan permission, cek apakah user punya permission
                if (!hasPermission($permission)) {
                    return redirect()->to('/access-denied'); // Atau halaman lain sesuai kebutuhan
                }
            }
        }

        // Cek apakah filter ini ditetapkan untuk controller dan method tertentu
        // if (!hasPermission($permission)) {
        //     return redirect()->to('/access-denied'); // Atau halaman lain sesuai kebutuhan
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan tindakan setelahnya
    }
}
