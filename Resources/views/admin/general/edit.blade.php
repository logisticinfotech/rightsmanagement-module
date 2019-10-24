@extends('rightsmanagement::admin.layouts.app')
@section('title', 'Edit '. $module_name)
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		@if(isset($module_name))
		<h2>{{  $module_name }}</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('/admins') }}">Home</a>
			</li>
			<li class="breadcrumb-item">
				<a>Edit {{ $module_name }}</a>
			</li>
		</ol>
		@endif
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					@if(isset($module_name))
					<h5>Edit {{ $module_name }}</h5>
					@endif
				</div>
				<div class="ibox-content">
					<div class="w-75 mx-auto">
						<form id='form_validate' class='form-horizontal' method="POST"
							action="{{ $module_route.'/'.$result['id'] }}" autocomplete='off'>
							@csrf
							<input name="_method" type="hidden" value="PUT">

							@include("rightsmanagement::admin.$moduleView._form")

							<div class="form-group">
								<div class="text-right">
									<a href="{{ $module_route }}" class="btn btn-danger mr-2">Cancel</a>
									<button class="btn btn-primary " type="submit">Save</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection