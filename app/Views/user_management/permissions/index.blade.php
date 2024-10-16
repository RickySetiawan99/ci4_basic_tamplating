@extends('layouts.app')

@section('content')
<div class="content-wrapper p-2">
    <div class="row p-2">
        <div class="col-md-12">
            <div class="card" style="border-radius: 10px;">
                <div class="card-header card-content">
                    <div class="row align-items-center">
                        <div class="col">
                            <small>{{ $header }}</small>
                            <h5 class="mb-0">List - {{ $sub_header }}</h5>
                        </div>
                        @can('permission-create')
                            <div class="col text-end">
                                <a href="{{ route($route.'create') }}" class="btn btn-md bg-gradient-success btn-tooltip" data-bs-toggle='tooltip' title='Tambah' data-container='body' data-animation='true'>
                                    <span class='btn-inner--icon'><i class='fa fa-plus'></i></span>
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="card-body table-responsive">

                    {{-- searching --}}
                    <div class="card shadow-none border mb-4" style="border-radius: 10px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama:</label>
                                        <input type="text" name="name" class="form-control" id="searchName" placeholder="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-md btn-primary my-2" id="btn-search"><i class="fa fa-search mx-2" aria-hidden="true"></i>Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end searching --}}

                    <table class="table table-hover justify-content-center mb-0" id="data-table">
                        <thead class="text-white bg-secondary-blue">
                            <tr>
                                <th width="5%" class="text-uppercase text-xxs text-center">No</th>
                                <th class="text-uppercase text-xxs text-left">Permission</th>
                                <th width="20%" class="text-uppercase text-xxs text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets') }}/js/custom_datatable.js"></script>
<script src="{{ asset('js') }}/blockui/jquery.blockUI.js"></script>
<script>
    $(document).ready(function () {
        datatable();

        $("#btn-search").on('click', function(){
            var name  = $('#searchName').val();
            datatable(name);
        })

        function datatable(name = null) {
            var id_datatable = "#data-table";
            var url_ajax = '{!! route($route.'getData') !!}';
            var column = [
                { data: 'DT_RowIndex', searchable: false, orderable: false, className: 'text-center align-middle text-sm' },
                { data: 'name', name: 'name', className: 'align-middle text-sm' },
                { data: 'aksi', name: 'aksi', className: 'text-center align-middle text-sm'},
            ];
            var data = {
                name : name
            };
            var search = false;
            global.init_datatable(id_datatable, url_ajax, column, data, search);
        }
    });
</script>
@endpush
