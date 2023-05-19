@extends('admin.layouts.page')

@section('title', 'Moderators')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Moderators</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Moderators</li>
        </ol>
      </div>
    </div>
  </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="text-left" style="margin: 20px 0 0 20px">
                <a class="btn btn-success" href="{{ route("admin.moderators.create") }}">
                    <i class="fas fa-plus">
                    </i>
                    Add new Moderator
                </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Patronymic</th>
                            <th>Login</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->surname }}</td>
                            <td>{{ $value->patronymic }}</td>
                            <td>{{ $value->login }}</td>
                            <td>{{ $value->email }}</td>
                            <td>
                                @foreach ($value->roles as $role)
                                {{ $role->name }}
                                @endforeach
                            </td>
                            <td>
                                @foreach ($value->getAllPermissions() as $permission)
                                {{ $permission->name }},
                                @endforeach
                            </td>
                            <td class="text-center">
                                <form action="{{ route("admin.moderators.destroy", $value->id) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <a href="{{ route("admin.moderators.edit", $value->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    @if($value->id != auth('admin')->user()->id)
                                    <button class="btn btn-danger btn-sm" type="submit">
                                        <i class="fas fa-trash">
                                        </i>
                                        Delete
                                    </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Patronymic</th>
                            <th>Login</th>
                            <th>Email</th>
                            <th>Role</th>
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
