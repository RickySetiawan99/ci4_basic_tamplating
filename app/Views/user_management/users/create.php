<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="content-wrapper p-2">
    <div class="row p-2">
        <div class="col-md-12">
            <div class="card" style="border-radius: 10px;">
                <div class="card-header card-content">
                    <div class="row align-items-center">
                        <div class="col">
                             <small><?= $header ?></small>
                            <h5 class="mb-0">Create - <?= $sub_header ?></h5>
                        </div>
                        <div class="col text-end">
                            <a href="<?= $route_back ?>" class="btn bg-gradient-warning ml-5 text-white">Cancel</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url($route.'/store') ?>" method="post" class="forms-sample" >
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-input">Status</label>
                                    <select class="form-control select" name="active" style="width: 100%;">
                                        <option value="1" selected="selected">Active</option>
                                        <option value="0">Non Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-input">Email</label>
                                    <input type="email" name="email" class="form-control <?= session('error.email') ? 'is-invalid' : '' ?>" value="<?= old('email') ?>" placeholder="example@mail.com" autocomplete="off">
                                    <?php if (session('error.email')) { ?>
                                        <div class="invalid-feedback">
                                            <h6 class="text-danger text-xs"><?= session('error.email') ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-input">Username</label>
                                    <input type="text" name="username" class="form-control <?= session('error.username') ? 'is-invalid' : '' ?>" value="<?= old('username') ?>" placeholder="Username" autocomplete="off">
                                    <?php if (session('error.username')) { ?>
                                        <div class="invalid-feedback">
                                            <h6 class="text-danger text-xs"><?= session('error.username') ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-input">Password</label>
                                    <input type="password" name="password" class="form-control <?= session('error.password') ? 'is-invalid' : '' ?>" placeholder="Password" autocomplete="off">
                                    <?php if (session('error.password')) { ?>
                                        <div class="invalid-feedback">
                                            <h6 class="text-danger text-xs"><?= session('error.password') ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-input">Password Confirm</label>
                                    <input type="password" name="pass_confirm" class="form-control <?= session('error.pass_confirm') ? 'is-invalid' : '' ?>" placeholder="Password Confirm" autocomplete="off">
                                    <?php if (session('error.pass_confirm')) { ?>
                                        <div class="invalid-feedback">
                                            <h6 class="text-danger text-xs"><?= session('error.pass_confirm') ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-input">Permission</label>
                            <select class="duallistbox" name="permission[]" multiple="multiple" data-placeholder="Permission" style="width: 100%;">
                            <?php foreach ($permissions as $permission) { ?>
                                <option <?= in_array($permission['id'], old('permission', [])) ? 'selected' : '' ?> value="<?= $permission['id'] ?>"><?= $permission['name'] ?></option>
                            <?php } ?>
                            </select>
                            <?php if (session('error.permission')) { ?>
                                <h6 class="text-danger text-xs"><?= session('error.permission') ?></h6>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label class="text-input">Role</label>
                            <select class="form-control duallistbox" name="role[]" multiple="multiple" data-placeholder="Role" style="width: 100%;">
                            <?php foreach ($roles as $role) { ?>
                                <option <?= in_array($role->id, old('role', [])) ? 'selected' : '' ?> value="<?= $role->id ?>"><?= $role->name ?></option>
                            <?php } ?>
                            </select>
                            <?php if (session('error.role')) { ?>
                                <h6 class="text-danger text-xs"><?= session('error.role') ?></h6>
                            <?php } ?>
                        </div>
    
                        <div class="col text-end">
                            <button type="submit" class="btn bg-gradient-primary">Save</button>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
</script>
<?= $this->endSection() ?>