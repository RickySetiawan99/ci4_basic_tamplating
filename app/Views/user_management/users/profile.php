<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="content-wrapper p-2">
    <div class="row p-2">
        <div class="col-lg-12">
            <div class="card settings-card-1 mb-30">
                <div class="card-header card-content">
                    <div class="row align-items-center">
                        <div class="col">
                             <small><?= $header ?></small>
                            <h5 class="mb-0">Update - <?= $sub_header ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-6 offset-sm-3">
                            <div class="profile-info">
                                <div class="d-flex d-flex justify-content-center m-3">
                                    <div class="profile-image">
                                        <img src="<?= base_url('assets') ?>/img/bg-profile.jpg" alt="Profile Image" class="profile-pic" />
                                        <!-- <div class="update-image">
                                            <input type="file" />
                                            <label for=""><i class="lni lni-cloud-upload"></i></label>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="<?= route_to('user-profile') ?>" method="post" class="form-horizontal">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 offset-sm-3 col-form-label text-input">Email</label>
                            <div class="col-sm-6 offset-sm-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control <?= session('error.email') ? 'is-invalid' : '' ?>" value="<?= user()->email ?>" autocomplete="off" aria-describedby="basic-addon1">
                                    <?php if (session('error.email')) { ?>
                                        <div class="invalid-feedback">
                                            <h6 class="text-danger text-xs"><?= session('error.email') ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-4 offset-sm-3 col-form-label text-input">Username</label>
                            <div class="col-sm-6 offset-sm-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                    <input type="text" name="username" class="form-control <?= session('error.username') ? 'is-invalid' : '' ?>" value="<?= user()->username ?>" placeholder="Username" autocomplete="off" aria-describedby="basic-addon2">
                                    <?php if (session('error.username')) { ?>
                                        <div class="invalid-feedback">
                                            <h6 class="text-danger text-xs"><?= session('error.username') ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-4 offset-sm-3 col-form-label text-input">Password</label>
                            <div class="col-sm-6 offset-sm-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control <?= session('error.password') ? 'is-invalid' : '' ?>" placeholder="Password" autocomplete="off">
                                    <?php if (session('error.password')) { ?>
                                        <div class="invalid-feedback">
                                            <h6 class="text-danger text-xs"><?= session('error.password') ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="passwordConfirm" class="col-sm-4 offset-sm-3 col-form-label text-input">Password Confirm</label>
                            <div class="col-sm-6 offset-sm-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="pass_confirm" class="form-control <?= session('error.pass_confirm') ? 'is-invalid' : '' ?>" placeholder="Password" autocomplete="off">
                                    <?php if (session('error.pass_confirm')) { ?>
                                        <div class="invalid-feedback">
                                            <h6 class="text-danger text-xs"><?= session('error.pass_confirm') ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-3">
                                <div class="float-right">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-md btn-block bg-gradient-primary">
                                            Update Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>