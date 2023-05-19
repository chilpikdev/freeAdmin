@extends('admin.layouts.page')

@section("title", "Settings")

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Settings</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Settings</li>
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
        <!-- /.card-header -->
        <div class="card-body">
            <div class="card-header">
                <h3 class="card-title">Set Values</h3>
            </div>
        <table id="datatable" class="table">
            <thead>
                <tr>
                    <th width="30%">Name</th>
                    <th width="50%">Value</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $value)
                <tr>
                    <td>{{ $value->title }}</td>
                    <td>
                        @if (!empty($value->value) && file_exists(public_path($value->value)))
                        <div class="form-group">
                            <img style="width:20%" src="{{ asset($value->value) }}">
                        </div>
                        @else
                            {{ $value->value }}
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route("admin.settings.edit", $value->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Value</th>
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
        "paging": false,
        "searching": false,
        "ordering": false,
        "info": false,
       });
    });
</script>
@stop
