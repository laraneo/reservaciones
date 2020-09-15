@extends('layouts.customer', ['title' => __('backend.my_profile')])
@section('content')

    <div class="page-title">
        <h3>{{ __('backend.my_profile') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.my_profile') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.profile')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.my_profile') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-2">
                            <p class="text-center">
                                <img src="{{$user->photo ? asset($user->photo->file) :
                                asset('images/profile-placeholder.png') }}"
                                     class="img-circle avatar avatar-margin" height="100" width="100">
                            </p>
                        </div>

                        <div class="col-md-8">
                            <form method="post" action="{{ route('customerUpdate', $user->id) }}" enctype="multipart/form-data">

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

                                <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                                    <label class="control-label" for="email">{{ __('backend.email') }}</label>
                                    <input type="email" class="form-control" name="email" value="{{$user->email}}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
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
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.update') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection