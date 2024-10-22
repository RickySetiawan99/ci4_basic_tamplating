<?php

use CodeIgniter\CLI\CLI;
use Myth\Auth\Models\PermissionModel;

if (!function_exists('parsingAlert')) {
    function parsingAlert($message)
    {
        $string = '<ul>'; // Start the unordered list

        if (is_array($message)) {
            foreach ($message as $value) {
                $string .= '<li>' . ucfirst($value) . '</li>'; // Wrap each message in a <li>
            }
        } else {
            $string .= '<li>' . ucfirst($message) . '</li>'; // If it's not an array, wrap the single message in a <li>
        }

        $string .= '</ul>'; // Close the unordered list

        return $string;
    }
}

if (!function_exists('hasPermission')) {
    /**
     * Mengecek apakah user punya permission yang diperlukan
     *
     * @param string $permission
     * @return bool
     */
    function hasPermission($permission)
    {
        // Mendapatkan ID user yang sedang login
        $userId = user_id(); // Function dari Myth\Auth untuk mendapatkan user ID

        // Cek jika user tidak ada
        if (is_null($userId)) {
            return false;
        }

        // Dapatkan permission model
        $permissionModel = new PermissionModel();
        
        // Ambil permission yang dimiliki user
        $userPermissions = $permissionModel->getPermissionsForUser($userId);

        // Cek apakah permission yang diminta ada dalam daftar permission user
        return in_array($permission, $userPermissions);
    }
}

if (!function_exists('clear_cache')) {
    function clear_cache()
    {
        // Membersihkan cache aplikasi
        service('cache')->clean();
    }
}