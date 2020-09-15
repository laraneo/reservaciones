@extends('layouts.admin', ['title' => __('backend.edit_user')])
@section('content')

    <div class="page-title">
        <h3>{{ __('backend.edit_user') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('users.index') }}">{{ __('backend.users') }}</a></li>
                <li class="active">{{ __('backend.edit_user') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.edit_user') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-2">
                            <p class="text-center">
                                <img src="{{$user->photo ? asset($user->photo->file) :
                                asset('images/profile-placeholder.png') }}"
                                     class="img-circle avatar avatar-margin" height="100" width="100">
                            </p>
                            <br>
                            @if($user->id != Auth::user()->id)
                                <div class="text-center">
                                    <form method="post" action="{{route('users.destroy', $user->id)}}">
                                        {{csrf_field()}}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                        </div>

                        <div class="col-md-8">
                            <form method="post" action="{{route('users.update', $user->id)}}" enctype="multipart/form-data">

                                {{csrf_field()}}
                                {{ method_field('PATCH') }}

                                <div class="form-group{{$errors->has('first_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="first_name">{{ __('backend.first_name') }}</label>
                                    <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}">
                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{$errors->has('last_name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="last_name">{{ __('backend.last_name') }}</label>
                                    <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}">
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{$errors->has('phone_number') ? ' has-error' : ''}}">
                                    <label class="control-label" for="phone_number">{{ __('backend.phone_number') }}</label>
                                    <input type="text" class="form-control" name="phone_number" value="{{$user->phone_number}}">
                                    @if ($errors->has('phone_number'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{$errors->has('doc_id') ? ' has-error' : ''}}">
                                    <label class="control-label" for="doc_id">{{ __('backend.doc_id') }}</label>
                                    <input type="text" class="form-control" name="doc_id" value="{{$user->doc_id}}">
                                    @if ($errors->has('doc_id'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('doc_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
								
                                <div class="form-group{{$errors->has('group_id') ? ' has-error' : ''}}">
                                    <label class="control-label" for="group_id">{{ __('backend.group_id') }}</label>
                                    <input type="text" class="form-control" name="group_id" value="{{$user->group_id}}">
                                    @if ($errors->has('group_id'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('group_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
								
								
                                <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                                    <label class="control-label" for="email">{{ __('backend.email') }}</label>
                                    <input type="email" class="form-control" name="email" value="{{$user->email}}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>								
								
								

                                <div class="form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                    <label class="control-label" for="is_active">{{ __('backend.status') }}</label>
                                    <select class="form-control" name="is_active">
                                        @if($user->is_active==1)
                                            <option value="1" selected>{{ __('backend.active') }}</option>
                                            <option value="0">{{ __('backend.disabled') }}</option>
                                        @else
                                            <option value="1">{{ __('backend.disabled') }}</option>
                                            <option value="0" selected>{{ __('backend.disabled') }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group{{$errors->has('role_id') ? ' has-error' : ''}}">
                                    <label class="control-label" for="role_id">{{ __('backend.role') }}</label>
                                    <select class="form-control" name="role_id">
                                        <option value="0">{{ __('backend.select_one') }}</option>
                                        @foreach($roles as $role)
                                            @if($user->role_id == $role->id)
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

                                <div class="form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                                    <label for="photo_id" class="control-label">{{ __('backend.select_profile_image') }}</label>
                                    <input type="file" id="photo_id" name="photo_id">
                                    @if ($errors->has('photo_id'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.update_user') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection