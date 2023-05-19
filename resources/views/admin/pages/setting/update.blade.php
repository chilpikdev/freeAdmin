@extends('admin.layouts.page')

@section("title", "Редактировать {$data->title}")

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Setting</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route("admin.settings.index") }}">Settings</a></li>
          <li class="breadcrumb-item active">Edit {$data->title}</li>
        </ol>
      </div>
    </div>
</div>
@stop

@section("content")
<div class="container-fluid">
    <form action="{{ route('admin.settings.update', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Edit {{ $data->title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Key</label>
                    <input type="text" class="form-control" disabled="disabled" style="width: 100%;" value="{{ $data->key }}">
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <!-- /.form-group -->
                    <div class="form-group">
                      <label>Value</label>
                      {!! $data->type !!}
                    </div>
                    <input type="hidden" name="value_old" id="value_old" value="{{ $data->value }}">
                    <script>
                        document.getElementById("value").value = document.getElementById("value_old").value;
                    </script>
                    <!-- /.form-group -->
                    @error('value')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror

                    @if (!empty($data->value) && file_exists(public_path($data->value)))
                    <div class="col-md-3 FileRow">
                        <div class="form-group">
                            <div class="image-area">
                                <img src="{{ asset($data->value) }}" alt="Preview">
                                <a class="remove-image" href="#" data-table="{{ $data->getTable() }}" data-itemid="{{ $data->id }}" data-fieldname="value" data-filename="{{ $data->value }}" style="display: inline;">&#215;</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
          </div>
          <!-- /.card -->
    </form>
</div>
@endsection

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
