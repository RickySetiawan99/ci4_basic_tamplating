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
                    <form action="<?= base_url($route.'/update/'.encode_id($data->id)) ?>" method="post" class="forms-sample">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="put" />
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-input">Name</label>
                                <input type="text" name="name" class="form-control <?= session('error.name') ? 'is-invalid' : '' ?>" value="<?= $data->name ?>" placeholder="name" autocomplete="off">
                                <?php if (session('error.name')) { ?>
                                    <div class="invalid-feedback text-xs">
                                        <h6 class="text-danger text-xs"><?= session('error.name') ?></h6>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-input">Description</label>
                                <input type="text" name="description" class="form-control <?= session('error.description') ? 'is-invalid' : '' ?>" value="<?= $data->description ?>" placeholder="description" autocomplete="off">
                                <?php if (session('error.description')) { ?>
                                    <div class="invalid-feedback text-xs">
                                        <h6 class="text-danger text-xs"><?= session('error.description') ?></h6>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="text-input">Permission</label>
                                    <select class="duallistbox" multiple="multiple" name="permission[]" title="permission[]">
                                    <?php foreach ($permissions as $value) { ?>
                                        <?php if (array_key_exists($value['id'], $permission)) { ?>
                                            <option value="<?= $value['id'] ?>" selected><?= $value['name'] ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                    </select> 
                                    <?php if (session('error.permission')) { ?>
                                        <h6 class="text-danger"><?= session('error.permission') ?></h6>
                                    <?php } ?>
                                </div>
                            </div>
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