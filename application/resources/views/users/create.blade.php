@extends('layouts.admin', ['title' => __('backend.add_new_user')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.add_new_user') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('users.index') }}">{{ __('backend.users') }}</a></li>
                <li class="active">{{ __('backend.add_new_user') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.add_new_user') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

                            <div class="col-md-6 form-group{{$errors->has('first_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="first_name">{{ __('backend.first_name') }}</label>
                                <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}">
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('last_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="last_name">{{ __('backend.last_name') }}</label>
                                <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone_number">{{ __('backend.phone_number') }}</label>
                                <input type="text" class="form-control" name="phone_number" value="{{old('phone_number')}}">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}">
                                <label class="control-label" for="email">{{ __('backend.email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                                <div class="col-md-6 form-group{{$errors->has('doc_id') ? ' has-error' : ''}}">
                                    <label class="control-label" for="doc_id">{{ __('backend.doc_id') }}</label>
                                    <input type="text" class="form-control" name="doc_id" value="{{$user->doc_id}}">
                                    @if ($errors->has('doc_id'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('doc_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
								
                                <div class="col-md-6 form-group{{$errors->has('group_id') ? ' has-error' : ''}}">
                                    <label class="control-label" for="group_id">{{ __('backend.group_id') }}</label>
                                    <input type="text" class="form-control" name="group_id" value="{{$user->group_id}}">
                                    @if ($errors->has('group_id'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('group_id') }}</strong>
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

                            <div class="col-md-12 form-group{{$errors->has('role_id') ? ' has-error' : ''}}">
                                <label class="control-label" for="role_id">{{ __('backend.role') }}</label>
                                <select class="form-control" name="role_id">
                                    <option value="0">{{ __('backend.select_one') }}</option>
                                    @foreach($roles as $role)
                                        @if(old('role_id')==$role->id)
                                            <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                        @else
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{$errors->has('password') ? ' has-error' : ''}}">
                                <label class="control-label" for="password">{{ __('backend.password') }}</label>
                                <input type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                                <label for="photo_id" class="control-label">{{ __('backend.select_profile_image') }}</label>
                                <input type="file" id="photo_id" name="photo_id">
                                @if ($errors->has('photo_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.create_user') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection