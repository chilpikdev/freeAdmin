@extends('admin.layouts.page')

@section("title", isset($data) ? "Edit post ID {$data->id}" : "Add new Entry")

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ isset($data) ? "Edit post ID {$data->id}" : "Add new Entry" }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route("admin.roles.index") }}">Roles</a></li>
          <li class="breadcrumb-item active">{{ isset($data) ? "Edit post ID {$data->id}" : "Add new Entry" }}</li>
        </ol>
      </div>
    </div>
</div>
@stop

@section("content")
<div class="container-fluid">
    <form action="@if(isset($data)) {{ route('admin.roles.update', $data->id) }} @else {{ route('admin.roles.store') }} @endif" method="POST">
        @csrf
        @if (isset($data))
            @method("PUT")
        @endif
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card">
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Role name</label>
                            <input type="text" class="form-control @error('name') border-red-500 @enderror" name="name" id="name" @if(old('name')) value="{{ old('name') }}" @elseif(isset($data)) value="{{ $data->name }}" @endif>
                        </div>
                        @error('name')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <div class="form-group">
                            <label>Permissions for Role:</label>
                            @if (isset($permissions))
                            @foreach ($permissions as $key => $value)
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="permissions[]" type="checkbox" id="customCheckbox{{$key}}" @if(old('permissions')) @foreach(old('permissions') as $val) @if($val == $value->name) checked @endif @endforeach @elseif(isset($data)) @foreach($data->permissions as $val) @if($val->name == $value->name) checked @endif @endforeach @endif value="{{ $value->name }}">
                                <label for="customCheckbox{{$key}}" class="custom-control-label">{{ $value->name }}</label>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </form>
</div>
@endsection
