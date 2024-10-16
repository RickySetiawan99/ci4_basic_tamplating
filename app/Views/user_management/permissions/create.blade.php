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
                                    <label for="PrefixPermissionName" class="text-input">Prefix Permission Name  <span style="color: red" data-toggle="tooltip" data-placement="right" title="Form ini harus diisi!">*</span></label>
                                    <input type="text" name="name" class="form-control" id="PrefixPermissionName" placeholder="Example : Admin" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="PermissionName" class="text-input">Permission Name  <span style="color: red" data-toggle="tooltip" data-placement="right" title="Form ini harus diisi!">*</span></label>
                                    <div class="card shadow-none border h-100">
                                        <div class="card-body">
                                            @foreach ($permission as $key => $value)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="permission[]" value="{{ $value }}" id="customCheck{{$key}}">
                                                    <label class="form-check-label" for="customCheck{{$key}}">
                                                        {{ $value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
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
</div>

@endsection
@push('js')
    <script>

    </script>
@endpush