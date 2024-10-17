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
                        <div class="col text-end">
                            <a href="<?= base_url($route.'/create') ?>" class="btn btn-md bg-gradient-success btn-tooltip my-0" data-bs-toggle='tooltip' title='Add' data-container='body' data-animation='true'>
                                <span class='btn-inner--icon'><i class='fa fa-plus'></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">

                    <!-- searching -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" id="nameFilter" class="form-control" placeholder="Filter by Name">
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
                                <th width="5%" class=" text-uppercase text-xxs text-center">No</th>
                                <th class=" text-uppercase text-xxs text-left">Name</th>
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
<script src="<?= base_url('assets') ?>/js/custom_datatable_new.js"></script>
<script>
    $(document).ready(function () {

        var selector = '#dataTable';
        var url = '<?= base_url($route.'/fetchData') ?>';
        var filters = {
            name: '#nameFilter',   // Input filter untuk name
        };
        var columns = [
            { "data": "no" },
            { "data": "name" },
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