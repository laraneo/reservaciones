@extends('layouts.admin', ['title' => __('backend.edit_guest')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.edit_guest') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('guests.index') }}">{{ __('backend.guests') }}</a></li>
                <li class="active">{{ __('backend.edit_guest') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.edit_guest') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-2">
                            <br>
                                <div class="text-center">
                                    <form method="post" action="{{route('guests.destroy', $guest->doc_id)}}">
                                        {{csrf_field()}}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                        </div>
                                    </form>
                                </div>
                        </div>

                        <div class="col-md-8">
                            <form method="post" action="{{route('guests.update', $guest->doc_id)}}" enctype="multipart/form-data">

                                {{csrf_field()}}
                                {{ method_field('PATCH') }}

								<div class="form-group{{$errors->has('doc_id') ? ' has-error' : ''}}">
									<label class="control-label" for="doc_id">{{ __('backend.doc_id') }}</label>
									<input type="text" class="form-control" name="doc_id" value="{{$guest->doc_id}}">
									@if ($errors->has('doc_id'))
										<span class="help-block">
											<strong class="text-danger">{{ $errors->first('doc_id') }}</strong>
										</span>
									@endif
								</div>
								
								<div class="form-group{{$errors->has('first_name') ? ' has-error' : ''}}">
									<label class="control-label" for="first_name">{{ __('backend.first_name') }}</label>
									<input type="text" class="form-control" name="first_name" value="{{$guest->first_name}}">
									@if ($errors->has('first_name'))
										<span class="help-block">
											<strong class="text-danger">{{ $errors->first('first_name') }}</strong>
										</span>
									@endif
								</div>
								
								<div class="form-group{{$errors->has('last_name') ? ' has-error' : ''}}">
									<label class="control-label" for="last_name">{{ __('backend.last_name') }}</label>
									<input type="text" class="form-control" name="last_name" value="{{$guest->last_name}}">
									@if ($errors->has('last_name'))
										<span class="help-block">
											<strong class="text-danger">{{ $errors->first('last_name') }}</strong>
										</span>
									@endif
								</div>

								<div class="form-group{{$errors->has('phone_number') ? ' has-error' : ''}}">
									<label class="control-label" for="phone_number">{{ __('backend.phone_number') }}</label>
									<input type="tel" class="form-control" name="phone_number" value="{{$guest->phone_number}}">
									@if ($errors->has('phone_number'))
										<span class="help-block">
											<strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
										</span>
									@endif
								</div>
								
								<div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
									<label class="control-label" for="email">{{ __('backend.email') }}</label>
									<input type="email" class="form-control" name="email" value="{{$guest->email}}">
									@if ($errors->has('email'))
										<span class="help-block">
											<strong class="text-danger">{{ $errors->first('email') }}</strong>
										</span>
									@endif
								</div>
								
								<div class="form-group{{$errors->has('plays_month') ? ' has-error' : ''}}">
									<label class="control-label" for="plays_month">{{ __('backend.plays_month') }}</label>
									<input type="number" class="form-control" name="plays_month" value="{{$guest->plays_month}}" disabled>
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

                                <div class="form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                    <label class="control-label" for="is_active">{{ __('backend.status') }}</label>
                                    <select class="form-control" name="is_active">
                                        @if($guest->is_active==1)
                                            <option value="1" selected>{{ __('backend.active') }}</option>
                                            <option value="0">{{ __('backend.disabled') }}</option>
                                        @else
                                            <option value="1">{{ __('backend.active') }}</option>
                                            <option value="0" selected>{{ __('backend.disabled') }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.update_guest') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
