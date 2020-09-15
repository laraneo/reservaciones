@extends('layouts.admin', ['title' => __('backend.add_new_guest')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.add_new_guest') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('guests.index') }}">{{ __('backend.guests') }}</a></li>
                <li class="active">{{ __('backend.add_new_guest') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.add_new_guest') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('guests.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

							<div class="form-group{{$errors->has('doc_id') ? ' has-error' : ''}}">
								<label class="control-label" for="doc_id">{{ __('backend.doc_id') }}</label>
								<input type="text" class="form-control" name="doc_id">
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

							<div class="form-group{{$errors->has('phone_number') ? ' has-error' : ''}}">
								<label class="control-label" for="phone_number">{{ __('backend.phone_number') }}</label>
								<input type="tel" class="form-control" name="phone_number">
								@if ($errors->has('phone_number'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
									</span>
								@endif
							</div>
							
							<div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
								<label class="control-label" for="email">{{ __('backend.email') }}</label>
								<input type="email" class="form-control" name="email">
								@if ($errors->has('email'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
							
							<div class="form-group{{$errors->has('plays_month') ? ' has-error' : ''}}">
								<label class="control-label" for="plays_month">{{ __('backend.plays_month') }}</label>
								<input type="number" class="form-control" name="plays_month" disabled>
								@if ($errors->has('plays_month'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('plays_month') }}</strong>
									</span>
								@endif
							</div>
							
							<div class="form-group{{$errors->has('comments') ? ' has-error' : ''}}">
								<label class="control-label" for="comments">{{ __('backend.comments') }}</label>
								<input type="text" class="form-control" name="comments" value="{{$guest->comments}}">
								@if ($errors->has('comments'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('comments') }}</strong>
									</span>
								@endif
							</div>

							<div class="col-md-12 form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                <label class="control-label" for="is_active">{{ __('backend.status') }}</label>
                                <select class="form-control" name="is_active">
                                    <option value="1">{{ __('backend.active') }}</option>
                                    <option value="0">{{ __('backend.disabled') }}</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.create_guest') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
