@extends('layouts.app')

@section('content')

<div class="content-wrapper p-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="border-radius: 10px;">
                <div class="card-header card-content">
                    <div class="row align-items-center">
                        <div class="col">
                            <small>{{ $header }}</small>
                            <h5 class="mb-0">Tambah - {{ $sub_header }}</h5>
                        </div>
                    </div>
                </div>
                <form action="{{ route($route.'store') }}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="RoleName" class="text-input">Role Name <span style="color: red" data-toggle="tooltip" data-placement="right" title="Form ini harus diisi!">*</span></label>
                                    <input type="text" name="name" class="form-control" id="RoleName" placeholder="Example : Admin" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-input"> List Permission <span style="color: red" data-toggle="tooltip" data-placement="right" title="Form ini harus diisi!">*</span></label>
                                    <div class="row">
                                        @foreach ($data as $key => $value)
                                        <div class="col-lg-4 mb-4">
                                            <div class="accordion" id="accordionExample{{ $key }}">
                                                <table class="justify-content-center mb-0 border" width="100%">
                                                    <thead class="bg-secondary text-white table-accordion" id="heading{{ $key }}" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}">
                                                        <tr>
                                                            <td class="p-2 text-center">
                                                                {{ str_replace('-list', '', $value->first()->name) }}
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="collapse{{ $key }}" class="collapse show" aria-labelledby="heading{{ $key }}" data-parent="#accordionExample{{ $key }}">
                                                        <tr>
                                                            <td>
                                                                <ul class="my-3">
                                                                    <li class="list-group-item mb-3">
                                                                        <div class="form-check">
                                                                            <input type="checkbox" class="form-check-input check-all" id="checkAll{{ $key }}" data-key="{{ $key }}">
                                                                            <label class="form-check-label font-weight-bold" for="checkAll{{ $key }}">Check All</label>
                                                                        </div>
                                                                    </li>
                                                                    @foreach ($value as $key_value => $value_data)
                                                                        <li class="list-group-item">
                                                                            <div class="form-check">
                                                                                <input type="checkbox" class="form-check-input sub-checkbox{{ $key }} custom-check" data-key="{{ $key }}" name="permission_id[]" value="{{ $value_data->id }}" id="customCheck{{$key}}">
                                                                                <label class="form-check-label" for="customCheck{{$key}}">
                                                                                    {{ $value_data->name }}
                                                                                </label>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                {{-- <div class="card shadow-none border h-100">
                                                    <div class="card-body">
                                                        @foreach ($value as $key_value => $value_data)
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" name="permission_id[]" value="{{ $value_data->id }}" id="customCheck{{$key.$key_value}}">
                                                                <label class="form-check-label" for="customCheck{{$key.$key_value}}">
                                                                    {{ $value_data->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm bg-gradient-primary">Simpan</button>
                        <a class="btn btn-sm bg-gradient-light" href="{{ route($route.'index') }}">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{-- </div> --}}

@endsection
@push('js')
<script>
    $(document).ready(function(){
        // Ketika checkbox "Check All" diubah statusnya
        $('.check-all').on('change', function() {
            var key = $(this).attr('data-key');
            var isChecked = $(this).prop('checked');
            
            // Set semua sub-checkbox sesuai dengan status "Check All"
            $('.sub-checkbox' + key).prop('checked', isChecked);
        });

        // Ketika sub-checkbox diubah statusnya
        $('.custom-check').on('change', function() {
            var key = $(this).attr('data-key');
            var isAnyUnchecked = $('.sub-checkbox' + key + ':not(:checked)').length > 0;

            // Jika ada sub-checkbox yang tidak tercentang, nonaktifkan "Check All"
            $('#checkAll' + key).prop('checked', !isAnyUnchecked);
        });
    });
</script>
@endpush