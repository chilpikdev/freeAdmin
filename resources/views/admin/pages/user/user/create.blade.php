@extends('admin.layouts.page')

@section('title', isset($data) ? "Edit User" : "Add new User")

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ isset($data) ? "Edit User" : "Add new User" }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route("admin.users.index") }}">Users</a></li>
            <li class="breadcrumb-item active">{{ isset($data) ? "Edit User " : "Add new User" }}</li>
        </ol>
      </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <form action="@if(isset($data)) {{ route('admin.users.update', $data->id) }} @else {{ route('admin.users.store') }} @endif" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($data))
        @method("PUT")
    @endif
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
        <!-- general form elements -->
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">User data</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') border-red-500 @enderror" name="name" id="name" @if(old('name')) value="{{ old('name') }}" @elseif(isset($data)) value="{{ $data->name }}" @endif>
                </div>
                @error('name')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="surname">Surname</label>
                    <input type="text" class="form-control @error('surname') border-red-500 @enderror" name="surname" id="surname" @if(old('surname')) value="{{ old('surname') }}" @elseif(isset($data)) value="{{ $data->surname }}" @endif>
                </div>
                @error('surname')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="patronymic">Patronymic</label>
                    <input type="text" class="form-control @error('patronymic') border-red-500 @enderror" name="patronymic" id="patronymic" @if(old('patronymic')) value="{{ old('patronymic') }}" @elseif(isset($data)) value="{{ $data->patronymic }}" @endif>
                </div>
                @error('patronymic')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="login">Login</label>
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                    </div>
                    <input type="text" class="form-control @error('login') border-red-500 @enderror" name="login" id="login" @if(old('login')) value="{{ old('login') }}" @elseif(isset($data)) value="{{ $data->login }}" @endif>
                    </div>
                </div>
                @error('login')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                    </div>
                    <input type="text" class="form-control @error('email') border-red-500 @enderror" name="email" id="email" @if(old('email')) value="{{ old('email') }}" @elseif(isset($data)) value="{{ $data->email }}" @endif>
                    </div>
                </div>
                @error('email')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="password">{{ isset($data) ? "New Password" : "Password" }}</label>
                    <input type="password" class="form-control @error('password') border-red-500 @enderror" name="password" id="password">
                </div>
                @error('password')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="password_confirmation">Password confirmation</label>
                    <input type="password" class="form-control @error('password_confirmation') border-red-500 @enderror" name="password_confirmation" id="password_confirmation">
                </div>
                @error('password')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
        <!-- /.card -->

        </div>
        <!--/.col (left) -->

        <!-- right column -->
        <div class="col-md-6">
        <!-- Form Element sizes -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Avatar</h3>
            </div>
            <div class="card-body">
                @if (isset($data) && $data->images)
                    <div class="row">
                        @foreach (json_decode($data->images) as $value)
                        <div class="col-md-3 FileRow">
                            <div class="form-group">
                                <div class="image-area">
                                    <img src="{{ asset($value) }}" alt="Preview">
                                    <a class="remove-image" href="#" data-table="{{ $data->getTable() }}" data-itemid="{{ $data->id }}" data-fieldname="images" data-filename="{{ $value }}" style="display: inline;">&#215;</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <div class="input-group">
                            <div class="custom-file">
                            <input type="file" class="custom-file-input @error('images') border-red-500 @enderror" name="images[]" id="images" multiple>
                            <label class="custom-file-label" for="images">Select a file</label>
                            </div>
                        </div>
                    </div>
                    @error('images')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                    @else
                    <div class="form-group">
                        <label>Images</label>
                        <div class="input-group">
                            <div class="custom-file">
                            <input type="file" class="custom-file-input @error('images') border-red-500 @enderror" name="images[]" id="images" multiple>
                            <label class="custom-file-label" for="images">Select a file</label>
                            </div>
                        </div>
                    </div>
                    @error('images')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- Form Element sizes -->
        </div>
        <!--/.col (right) -->

    </div>
    <!-- /.row -->
    </form>
</div>
@stop

@section('css')
<style>
    .image-area {
      position: relative;
      width: 150px;
    }
    .image-area img{
      max-width: 100%;
      height: auto;
    }
    .remove-image {
    display: none;
    position: absolute;
    top: -10px;
    right: -10px;
    border-radius: 10em;
    padding: 2px 6px 3px;
    text-decoration: none;
    font: 700 21px/20px sans-serif;
    background: #555;
    border: 3px solid #fff;
    color: #FFF;
    box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);
      text-shadow: 0 1px 2px rgba(0,0,0,0.5);
      -webkit-transition: background 0.5s;
      transition: background 0.5s;
    }
    .remove-image:hover {
     background: #E54E4E;
    }
    .remove-image:active {
     background: #E54E4E;
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $("body").on("click", ".remove-image", function () {
            $(this).parents(".FileRow").remove();

            var tableName = this.getAttribute('data-table');
            var itemId = this.getAttribute('data-itemid');
            var fieldName = this.getAttribute('data-fieldname');
            var fileName = this.getAttribute('data-filename');

            // alert(fileName);

            $.ajax({
                type: 'get',
                url: '/admin/delete-file',
                data: {
                    'table': tableName,
                    'id': itemId,
                    'fieldname': fieldName,
                    'filename': fileName,
                },
                success: function (data) {
                    // alert(data);
                    // location.reload();
                }
            });
        });
    });
</script>
@stop

