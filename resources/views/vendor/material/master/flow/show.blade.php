@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Flows Management<small>Detail Flow Items</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		{{ csrf_field() }}
        		<div class="form-group">
	                <label for="flow_group_id" class="col-sm-2 control-label">Flow Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="flow_group_id" id="flow_group_id" class="chosen" required="true" disabled="true">
	                        	<option value=""></option>
                                @foreach ($flowgroup as $row)
                                	{!! $selected = '' !!}
                                	@if($row->flow_group_id==$flow->flow_group_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->flow_group_id }}" {{ $selected }}>{{ $row->flow_group_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_name" class="col-sm-2 control-label">Flow Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="flow_name" id="flow_name" placeholder="Flow Name" required="true" maxlength="100" value="{{ $flow->flow_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_url" class="col-sm-2 control-label">Flow URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="flow_url" id="flow_url" placeholder="Flow URL" required="true" maxlength="255" value="{{ $flow->flow_url }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_no" class="col-sm-2 control-label">Flow No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" placeholder="Flow No" class="form-control input-sm" value="{{ $flow->flow_no }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_prev" class="col-sm-2 control-label">Previous Flow</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" placeholder="Previous Flow" class="form-control input-sm" value="{{ $flow->flow_prev }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_by" class="col-sm-2 control-label">Flow By</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="flow_by" id="flow_by" class="chosen" required="true" disabled="true">
	                        	<option value=""></option>
                                @foreach ($flowbyitems as $key => $value)
                                	{!! $selected = '' !!}
                                	@if($key == $flow->flow_by)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
								@endforeach
                            </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="role_id" class="col-sm-2 control-label">Role</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="role_id" id="role_id" class="chosen" required="true" disabled="true">
	                        	<option value=""></option>
                                @foreach ($role as $row)
                                	{!! $selected = '' !!}
                                	@if($row->role_id==$flow->role_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->role_id }}" {{ $selected }}>{{ $row->role_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/flow') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection