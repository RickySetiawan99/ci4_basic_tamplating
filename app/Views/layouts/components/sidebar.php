<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="<?= base_url('dashboard') ?>" target="_blank">
            <img src="<?= base_url('assets/img/logo-ct-dark.png') ?>" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">CI4 Template</span>
        </a>
    </div>
    <hr class="horizontal bg-primary-blue mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('/') ?>">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#navbar_user_manage" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar_user_manage">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-settings text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
                <div class="collapse <?= (uri_string() == 'user-management' || strpos(uri_string(), 'user-management/') === 0) ? 'show' : '' ?>" id="navbar_user_manage">
                    <ul class="navbar-nav px-3">
                        <li class="nav-item">
                            <a class="nav-link py-2 <?= (strpos(uri_string(), 'user-management/permissions/') === 0) ? 'active' : '' ?>" href="<?= base_url('user-management/permissions') ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa fa-key text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Permission</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-2 <?= (strpos(uri_string(), 'user-management/roles/') === 0) ? 'active' : '' ?>" href="<?= base_url('user-management/roles') ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa fa-gear text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Role</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-2 <?= (strpos(uri_string(), 'user-management/users/') === 0) ? 'active' : '' ?>" href="<?= base_url('user-management/users') ?>">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa fa-users text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">User</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>
