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
                            <h5 class="mb-0">Edit - <?= $sub_header ?></h5>
                        </div>
                        <div class="col text-end">
                            <a href="<?= $route_back ?>" class="btn bg-gradient-warning ml-5 text-white">Cancel</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url($route.'/update/'.encode_id($user->id)) ?>" method="post" class="forms-sample">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="put" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-input">Status</label>
                                    <select class="form-control select" name="active" style="width: 100%;">
                                        <option <?= $user->active == 1 ? 'selected' : '' ?> value="1">Active</option>
                                        <option <?= $user->active == 0 ? 'selected' : '' ?> value="0">Non Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-input">Email</label>
                                <input type="email" name="email" class="form-control <?= session('error.email') ? 'is-invalid' : '' ?>" value="<?= $user->email ?>" placeholder="example@mail.com" autocomplete="off">
                                <?php if (session('error.email')) { ?>
                                    <div class="invalid-feedback text-xs">
                                        <h6><?= session('error.email') ?></h6>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <label class="text-input">Username</label>
                                <input type="text" name="username" class="form-control <?= session('error.username') ? 'is-invalid' : '' ?>" value="<?= $user->username ?>" placeholder="Username" autocomplete="off">
                                <?php if (session('error.username')) { ?>
                                    <div class="invalid-feedback text-xs">
                                        <h6><?= session('error.username') ?></h6>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <label class="text-input">Password</label>
                                <input type="password" name="password" class="form-control <?= session('error.password') ? 'is-invalid' : '' ?>" placeholder="Password" autocomplete="off">
                                <?php if (session('error.password')) { ?>
                                    <div class="invalid-feedback text-xs">
                                        <h6><?= session('error.password') ?></h6>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <label class="text-input">Password Confirm</label>
                                <input type="password" name="pass_confirm" class="form-control <?= session('error.pass_confirm') ? 'is-invalid' : '' ?>" placeholder="Password" autocomplete="off">
                                <?php if (session('error.pass_confirm')) { ?>
                                    <div class="invalid-feedback text-xs">
                                        <h6><?= session('error.pass_confirm') ?></h6>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-input">Permission</label>
                            <select class="form-control duallistbox" name="permission[]" multiple="multiple" data-placeholder="Permission" style="width: 100%;">
                            <?php foreach ($permissions as $value) { ?>
                                <?php if (array_key_exists($value['id'], $permission)) { ?>
                                    <option value="<?= $value['id'] ?>" selected><?= $value['name'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                <?php } ?>
                            <?php } ?>
                            </select>
                            <?php if (session('error.permission')) { ?>
                                <h6 class="text-danger text-xs"><?= session('error.permission') ?></h6>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label class="text-input">Role</label>
                            <select class="form-control duallistbox" name="role[]" multiple="multiple" data-placeholder="Role" style="width: 100%;">
                            <?php foreach ($roles as $value) { ?>
                                <option value="<?= $value->id ?>" 
                                    <?= in_array((int) $value->id, array_column($role, 'group_id')) ? 'selected' : '' ?>>
                                    <?= $value->name ?>
                                </option>
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
    $('.duallistbox').bootstrapDualListbox();
</script>
<?= $this->endSection() ?>