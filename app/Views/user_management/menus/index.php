<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<?= $this->include('user_management/menus/update') ?>
<style>.fade.in{opacity: 1;}</style>
<div class="content-wrapper p-2">
    <div class="row p-2">
        <div class="col-md-12">
            <div class="card" style="border-radius: 10px;">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <small><?= $header ?></small>
                            <h5 class="mb-0">Add - <?= $sub_header ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?= route_to($route.'/list') ?>" method="post" class="form-horizontal">
                                <?= csrf_field() ?>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 text-input">Parent</label>
                                    <div class="col-sm-12">
                                        <select class="form-control parent" name="parent_id">
                                            <option selected value="0">ROOT</option>
                                            <?php foreach ($menus as $menu) { ?>
                                                <option <?= ($menu->id == old('parent_id')) ? 'selected' : '' ?> value="<?= $menu->id ?>"><?= $menu->title ?></option>
                                            <?php } ?>
                                        </select>
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation-triangle"></i>Tolong dicatat! menu hanya mendukung maksimal kedalaman 2.
                                        </span>
                                        <?php if (session('error.parent_id')) { ?>
                                            <div class="invalid-feedback">
                                                <h6 class="text-danger text-xs"><?= session('error.parent_id') ?></h6>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 text-input">Status</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="active">
                                            <option selected value="1">Active</option>
                                            <option value="0">Non Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 text-input">Icon</label>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-font-awesome-flag"></i></span>
                                            <input type="text" name="icon" class="icon-picker form-control <?= session('error.icon') ? 'is-invalid' : '' ?>" value="<?= old('icon') ?>" placeholder="Icon from FontAwesome" autocomplete="off">
                                            <?php if (session('error.icon')) { ?>
                                                <div class="invalid-feedback">
                                                    <h6 class="text-danger text-xs"><?= session('error.icon') ?></h6>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <span class="text-info">
                                            <i class="fa fa-info-circle"></i>More Icon <a href="http://fontawesome.io/icons" target="_blank">http://fontawesome.io/icons</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 text-input">Name</label>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            <input type="text" name="title" class="form-control <?= session('error.title') ? 'is-invalid' : '' ?>" value="<?= old('title') ?>" placeholder="name for menu" autocomplete="off">
                                            <?php if (session('error.title')) { ?>
                                                <div class="invalid-feedback">
                                                    <h6 class="text-danger text-xs"><?= session('error.title') ?></h6>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 text-input">Route</label>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                                            <input type="text" name="route" class="form-control <?= session('error.route') ? 'is-invalid' : '' ?>" value="<?= old('route') ?>" placeholder="link menu" autocomplete="off">
                                            <?php if (session('error.route')) { ?>
                                                <div class="invalid-feedback">
                                                    <h6 class="text-danger text-xs"><?= session('error.route') ?></h6>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 text-input">Role</label>
                                    <div class="col-sm-12">
                                        <select multiple="multiple" class="form-control parent" name="groups_menu[]" data-placeholder="role">
                                            <?php foreach ($roles as $role) { ?>
                                                <option <?= in_array($role->id, old('groups_menu', [])) ? 'selected' : '' ?> value="<?= $role->id ?>"><?= $role->name ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if (session('error.groups_menu')) { ?>
                                            <h6 class="text-danger"><?= session('error.groups_menu') ?></h6>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col text-start">
                                        <button type="submit" class="btn bg-gradient-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div id="nestable-menu" class="card-header pb-0">
                            <div class="btn-group">
                                <button class="btn bg-gradient-info tree-tools" data-action="expand" title="Expand">
                                    <i class="mx-1 fas fa-chevron-down"></i>Expand
                                </button>
                                <button class="btn bg-gradient-info tree-tools" data-action="collapse" title="Collapse">
                                    <i class="mx-1 fas fa-chevron-up"></i>Collapse
                                </button>
                            </div>
                            <div class="btn-group">
                                <button class="btn bg-gradient-primary save" data-action="save" title="Save">
                                    <i class="mx-1 fa fa-save"></i>Save
                                </button>
                            </div>
                            <div class="btn-group">
                                <button class="btn bg-gradient-warning refresh" data-action="refresh" title="Refresh">
                                    <i class="mx-1 fas fa-sync-alt"></i>Refresh
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dd" id="menu"></div>
                        </div>
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/dist/jquery.nestable.min.js"></script>
<script>
$(function () {
    $('.icon-picker').iconpicker({
        placement: 'bottomRight',
        hideOnSelect: true,
        inputSearch: true,
    });
    $('.parent').select2();

    menu();

    function menu() {
        $.get("<?= base_url($route.'/list') ?>", function(response) {
            $('.dd').nestable({
                maxDepth: 2,
                json: response.data,
                contentCallback: (item) => {
                    return `<div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="${item.icon}"></i>
                            <strong>${item.title}</strong><br/>
                            Link : <a href="<?= base_url() ?>${item.route}" class="dd-nodrag ms-2 text-primary">${item.route}</a>
                        </div>
                        <div class="d-flex align-items-center dd-nodrag">
                            <button data-id="${item.id}" id="btn-edit" class="btn btn-primary btn-md me-2 mb-0">
                                <i class="fa fa-pencil-alt"></i>
                            </button>
                            <button data-id="${item.id}" id="btn-delete" class="btn btn-danger btn-md mb-0">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>`;
                }
            });
        });
    }

    $('.tree-tools').on('click', function(e) {
        var action = $(this).data('action');
        if (action === 'expand') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('.save').on('click', function (e) {
        e.preventDefault();
        var serialize = $('#menu').nestable('toArray');
        var btnSave = $(this);
        $(this).attr('disabled', true);
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: `<?= route_to($route.'/update') ?>`,
            method: 'PUT',
            dataType: 'JSON',
            data: JSON.stringify(serialize)
        }).done((data, textStatus, jqXHR) => {
            Swal.fire({
                icon: 'success',
                title: jqXHR.statusText
            });
            btnSave.attr('disabled', false);
            btnSave.html('<i class="fa fa-save"></i> ' + "Save");
            $('.dd').nestable('destroy');
            menu();
        }).fail((error) => {
            Swal.fire({
                icon: 'error',
                title: error.responseJSON.messages.error,
            });
            btnSave.attr('disabled', false);
            btnSave.html('<i class="fa fa-save"></i> ' + "Save");
        })
    });

    $('.refresh').on('click', function (e) {
        location.reload(true);
    });

    $(document).on('click', '#btn-edit', function(e) {
        e.preventDefault();
        $('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: `<?= route_to($route.'/list') ?>/${$(this).attr('data-id')}/edit`,
            method: 'GET',
            dataType: 'JSON',
            
        }).done((response) => {

            $('#active').select2();
            $('#parent_id').select2({
                data: response.menu
            });
            $('#groups_menu').select2({
                data: response.roles
            });
            var editForm = $('#form-edit');

            var group_id = response.data.group_id;
            var group = group_id.split('|');
            var parent_id = response.data.parent_id == 0 ? 0 : response.data.parent_id;

            editForm.find('select[name="active"]').val(response.data.active).change();
            editForm.find('select[name="parent_id"]').val(parent_id).change();
            editForm.find('select[name="groups_menu[]"]').val(group).change();
            editForm.find('input[name="icon"]').val(response.data.icon);
            editForm.find('input[name="icon"]').val(response.data.icon);
            editForm.find('input[name="title"]').val(response.data.title);
            editForm.find('input[name="route"]').val(response.data.route);
            $("#menu_id").val(response.data.id);
            $('#modal-update').modal('show');

        }).fail((jqXHR, textStatus, errorThrown) => {
            Swal.fire({
                icon: 'error',
                title: jqXHR.responseJSON.messages.error,
            });
        })
    });

    $(document).on('click', '#btn-update', function(e) {
        $('.invalid-feedback').remove();
        var editForm = $('#form-edit');

        $.ajax({
            url: `<?= route_to($route.'/list') ?>/${ $('#menu_id').val() }`,
            method: 'PUT',
            data: editForm.serialize()
            
        }).done((data, textStatus, jqXHR) => {
            Swal.fire({
                icon: 'success',
                title: jqXHR.statusText
            });

            $('.dd').nestable('destroy');
            menu();
            $("#form-edit").trigger("reset");
            $("#modal-update").modal('hide');

        }).fail((xhr, status, error) => {
            $.each(xhr.responseJSON.messages, (elem, messages) => {
                editForm.find('input[name="' + elem + '"]').addClass('is-invalid').after('<p class="invalid-feedback">' + messages + '</p>');
            });
        })
    });

    $(document).on('click', '#btn-delete', function(e) {
        Swal.fire({
            title: "Apakah yakin hapus data ini?",
            text: "Lanjutkan untuk menghapus",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        })
        .then((result) => {
            if (result.value) {
                $.ajax({
                    url: `<?= route_to($route.'/list') ?>/${$(this).attr('data-id')}`,
                    method: 'DELETE',
                }).done((data, textStatus, jqXHR) => {
                    Swal.fire({
                        icon: 'success',
                        title: jqXHR.statusText,
                    });
                    $('.dd').nestable('destroy');
                    menu();
                }).fail((jqXHR, textStatus, errorThrown) => {
                    Swal.fire({
                        icon: 'error',
                        title: jqXHR.responseJSON.messages.error,
                    });
                })
            }
        })
    })

    $('#modal-edit').on('hidden.bs.modal', function() {
        $(this).find('#form-edit').reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').removeClass('invalid-feedback');
    });
})
</script>
<?= $this->endSection() ?>
