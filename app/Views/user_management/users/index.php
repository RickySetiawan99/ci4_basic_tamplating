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
                            <h5 class="mb-0">List - <?= $sub_header ?></h5>
                        </div>
                        <!-- @can('user-create') -->
                            <div class="col text-end">
                                <a href="<?= base_url($route.'/create') ?>" class="btn btn-md bg-gradient-success btn-tooltip my-0" data-bs-toggle='tooltip' title='Tambah' data-container='body' data-animation='true'>
                                    <span class='btn-inner--icon'><i class='fa fa-plus'></i></span>
                                </a>
                            </div>
                        <!-- @endcan -->
                    </div>
                </div>
                <div class="card-body table-responsive">

                    <!-- searching -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" id="nameFilter" class="form-control" placeholder="Filter by Name">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="emailFilter" class="form-control" placeholder="Filter by Email">
                        </div>
                        <div class="col-md-2">
                            <button id="filterBtn" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </div>
                    <!-- end searching  -->

                    <!-- table -->
                     <table id="dataTable" class="table table-hover justify-content-center mb-0">
                        <thead class="text-white bg-secondary-blue">
                            <tr>
                                <th width="5%" class=" text-uppercase text-xxs text-center">ID</th>
                                <th class=" text-uppercase text-xxs text-left">Name</th>
                                <th class=" text-uppercase text-xxs text-left">Email</th>
                                <th width="20%" class=" text-uppercase text-xxs text-center">Created At</th>
                                <th width="20%" class=" text-uppercase text-xxs text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- end table -->
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- <script src="<?= base_url('assets') ?>/js/custom_datatable.js"></script> -->
<script src="<?= base_url('assets') ?>/js/custom_datatable_new.js"></script>
<script src="<?= base_url('assets') ?>/js/blockui/jquery.blockUI.js"></script>
<script>
    $(document).ready(function () {

        var selector = '#dataTable';
        var url = '<?= base_url('user-management/users/fetchData') ?>';
        var filters = {
            name: '#nameFilter',   // Input filter untuk name
            email: '#emailFilter'  // Input filter untuk email
        };
        var columns = [
            { "data": "no" },
            { "data": "username" },
            { "data": "email" },
            { "data": "created_at" },
            { "data": "action" }
        ];
        var table = initSimpleDataTable(selector, url, filters, columns);

        // Event untuk filter
        $('#filterBtn').click(function() {
            table.draw();  // Memuat ulang DataTables dengan filter
        });
    });
</script>
<?= $this->endSection() ?>