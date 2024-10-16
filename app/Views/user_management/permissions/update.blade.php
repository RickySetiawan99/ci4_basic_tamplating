@extends('layouts.app')

@section('content')

<div class="content-wrappe p-2r">
    <div class="row p-2">
        <div class="col-md-12">
            <div class="card" style="border-radius: 10px;">
                <div class="card-header card-content">
                    <div class="row align-items-center">
                        <div class="col">
                            <small>{{ $header }}</small>
                            <h5 class="mb-0">Edit - {{ $sub_header }}</h5>
                        </div>
                    </div>
                </div>
                <form action="{{ route($route.'update') }}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{ Hashids::encode($data->id) }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="PermissionName" class="text-input">Permission Name  <span style="color: red" data-toggle="tooltip" data-placement="right" title="Form ini harus diisi!">*</span></label>
                                    <input type="text" name="name" value="{{ $data->name }}" class="form-control" id="PermissionName" placeholder="Example : Admin" autocomplete="off">
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