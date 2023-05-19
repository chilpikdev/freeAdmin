@extends('admin.layouts.page')

@section("title", "Roles")

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Roles</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Roles</li>
        </ol>
      </div>
    </div>
</div>
@stop

@section("content")
<div class="container-fluid">
<div class="row">
    <div class="col-12">
    <div class="card">
        <div class="text-left" style="margin: 20px 0 0 20px">
            <a class="btn btn-success" href="{{ route("admin.roles.create") }}">
                <i class="fas fa-plus">
                </i>
                Add new Entry
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th width="250px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $value)
                <tr>
                    <td>{{ $value->name }}</td>
                    <td>
                    @foreach ($value->permissions as $val)
                        {{ $val->name }},
                    @endforeach
                    </td>
                    <td class="text-center">
                        <form action="{{ route("admin.roles.destroy", $value->id) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <a href="{{ route("admin.roles.edit", $value->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Edit
                            </a>
                            <button class="btn btn-danger btn-sm" type="submit">
                                <i class="fas fa-trash">
                                </i>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
</div>
@stop

@section('css')
    <style>
        table{
            width:100%;
        }
        #datatable_filter{
            float:right;
        }
        #datatable_paginate{
            float:right;
        }
        label {
            display: inline-flex;
            margin-bottom: .5rem;
            margin-top: .5rem;
        }
        .actions {
            width: 230px;
        }
        .dataTables_empty {
            text-align: center;
        }
    </style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
    $('#datatable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "paging": true,
        // "searching": false,
        // "ordering": false,
        // "info": false,
       });
    });
</script>
@stop
