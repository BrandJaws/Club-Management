@extends('__layouts.admin') @section('main')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
                <i class="fa fa-angle-right"></i></li>
            <li><a href="{{url('/member')}}">Member</a></li>
        </ul>
        <div class="page-toolbar">
            <div id="" class="pull-right tooltips btn btn-fit-height" data-placement="top" data-original-title="Search Members">
                <div class="input-icon right">
                    <i class="icon-magnifier"></i>
                    <input type="text" class="form-control form-control-solid input-circle" placeholder="search..."> </div>
            </div>
        </div>
    </div>

    <h1 class="page-title">
        Members Pending Approval
    </h1>

    <!-- END PAGE HEADER-->


    <!-- BEGIN PROFILE CONTENT -->
    <div class="profile-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="clearfix"></div>
        							@if(Session::has('serverError'))
        								<div class="alert alert-warning" role="alert">
        									{{Session::get('serverError')}}</div>
        							@endif @if(Session::has('success'))
        								<div class="alert alert-success" role="alert">
        									{{Session::get('success')}}</div>
        							@endif

                                <table class="table table-hover customPaddingTable">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Parent Member</th>
                                        <th>Relation</th>
                                        <th>Gender</th>
                                        <th style="width: 150px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($data) && is_array($data))
                                        @foreach($data as $member)
                                        <tr>
                                            <td>{{array_get($member,'firstName')}} {{array_get($member,'lastName')}}</td>
                                            <td>{{array_get($member,'email')}}</td>
                                            <td>{{array_get($member,'main_member.firstName')}} {{array_get($member,'main_member.lastName')}}</td>
                                            <td>{{ucfirst(strtolower(array_get($member,'type')))}}</td>
                                            <td>{{ucfirst(strtolower(array_get($member,'gender')))}}</td>
                                            <td class="action-btns" style="width: 210px">
                                                <div class="btn-group btn-group-circle" style="">
                                                    <a style="padding: 5px 16px; width: 85px" href="{{route('member.approve',[array_get($member,'id')])}}" class="btn btn-outline green btn-sm"><i class="fa fa-check"></i>&nbsp;Approve</a>
                                                    <a  style="padding: 5px 16px; width: 85px" href="{{route('member.reject',[array_get($member,'id')])}}" class="btn btn-outline red btn-sm"><i class="fa fa-trash"></i>&nbsp;Reject</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    	<tr>
                                    		<td colspan="6">No accounts waiting for approval</td>
                                    	</tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PROFILE CONTENT -->
    <nav aria-label="Page navigation" class="text-center">
        {!! (isset($paginator))? $paginator->paginate():'' !!}
    </nav>

    <div class="clearfix"></div>
    <style>
        .action-btns span {
            float: left;
            margin-right: 5px;
        }

        .action-btns span button {
            border: 0;
        }
    </style>

@stop
