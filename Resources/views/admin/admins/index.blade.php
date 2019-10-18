@extends('rightsmanagement::admin.layouts.app')
@section('title', $module_name)
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>{{ $module_name }}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/admins') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a>{{ $module_name }} List</a>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    @if(isset($module_name))
                    <h5 class="card-title mb-0">{{  $module_name }} List</h5>
                    @endif
                    <div class="ibox-tools">
                        @can('admin_add')
                        <a class="btn btn-primary btn-xs" href="{{ route('admins.create') }}" title="Add"><i
                                class="fa fa-plus"></i> Add</a>
                        @endcan
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="users-datatable" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("scripts")
<script>
    $(document).ready(function(){

        var oTable = $('#users-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pagingType: "full_numbers",
            ajax: {
                url: "{!! $module_route.'/datatable' !!}",
                data: function ( d ) {
                }
            },
            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable:false, width: 20 },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data:  null,
                    orderable: false,
                    className:"text-center",
                    render:function(o){
                        var roles = "";
                        o.roles.forEach(role => {
                            if (role.display_name) {
                                if (roles) {
                                    roles += ", ";
                                }
                                roles += role.display_name;
                            }
                        });

                        return  roles;
                    }
                },
                {
                    data:  null,
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    targets: 0,
                    className:"text-center",
                    render:function(o){
                        var str = "";

                        str += "@can('user_edit') <a href='{!!  $module_route  !!}/"+  o.id +"/edit' class='btn-sm btn-primary'><i class='fa fa-edit'></i></a> @endcan";

                        str += `@can('user_delete')<a href='javascript:void(0);' class='btn-sm btn-danger' onClick="deleteUser(${o.id})"><i class='fa fa-trash'></i></a> @endcan`;
                        return str;
                    }
                }
            ]
        });

        deleteUser = (userId) => {
            console.log("deleteUser userId", userId);
            let url = '{{ $module_route }}/'+userId;
            deleteRecordByAjax(url, "{{$module_name}}", oTable);
        }

    });
</script>
@stop
