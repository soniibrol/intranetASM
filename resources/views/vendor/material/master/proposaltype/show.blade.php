@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Proposal Type Management<small>View Proposal Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="proposal_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_type_name" id="proposal_type_name" placeholder="Proposal Type Name" required="true" maxlength="100" value="{{ $proposaltype->proposal_type_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_type_duration" class="col-sm-2 control-label">Duration (day)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_type_duration" id="proposal_type_duration" placeholder="Proposal Type Duration (day)" required="true" maxlength="2" value="{{ $proposaltype->proposal_type_duration }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="proposal_type_desc" id="proposal_type_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $proposaltype->proposal_type_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/proposaltype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection