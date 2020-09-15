@extends('layouts.admin', ['title' => __('backend.add_new_blacklist')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.add_new_blacklist') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('blacklist.index') }}">{{ __('backend.blacklist') }}</a></li>
                <li class="active">{{ __('backend.add_new_blacklist') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.add_new_blacklist') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('blacklist.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

							<div class="form-group{{$errors->has('doc_id') ? ' has-error' : ''}}">
								<label class="control-label" for="doc_id">{{ __('backend.doc_id') }}</label>
								<input type="number" class="form-control" name="doc_id">
								@if ($errors->has('doc_id'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('doc_id') }}</strong>
									</span>
								@endif
							</div>
							
							<div class="form-group{{$errors->has('first_name') ? ' has-error' : ''}}">
								<label class="control-label" for="first_name">{{ __('backend.first_name') }}</label>
								<input type="text" class="form-control" name="first_name">
								@if ($errors->has('first_name'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('first_name') }}</strong>
									</span>
								@endif
							</div>
							
							<div class="form-group{{$errors->has('last_name') ? ' has-error' : ''}}">
								<label class="control-label" for="last_name">{{ __('backend.last_name') }}</label>
								<input type="text" class="form-control" name="last_name">
								@if ($errors->has('last_name'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('last_name') }}</strong>
									</span>
								@endif
							</div>

							<div class="form-group{{$errors->has('comments') ? ' has-error' : ''}}">
								<label class="control-label" for="comments">{{ __('backend.comments') }}</label>
								<input type="text" class="form-control" name="comments" value="{{$blacklist->comments}}">
								@if ($errors->has('comments'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('comments') }}</strong>
									</span>
								@endif
							</div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.create_blacklist') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
