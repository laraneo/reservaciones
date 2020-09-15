@extends('layouts.login', ['title' => __('passwords.page_title')])

@section('content')


    <div class="row">
        <div class="col-md-3 center">
            <div class="login-box">
                <p style="text-align:center;">
                    <a href="{{ route('index') }}" class="logo-name text-lg text-center"><img src="{{ asset('images/logo-dark.png') }}" class="img-responsive"></a>
                </p>
                <p class="text-center m-t-md">{{ __('passwords.page_title') }}</p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="m-t-md" method="post" action="{{ route('password.email') }}">
                    @csrf
					<!--
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('auth.email_placeholder') }}" value="{{ old('email') }}">
                        @if($errors->has('email'))
                            <p class="text-danger">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
					-->
					
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('auth.email_placeholder') }}" value="{{ old('email') }}">
						<!--
                        <input type="text" class="form-control" id="group_id" name="group_id" placeholder="{{ __('auth.group_id_placeholder') }}" value="">						
                        <input type="text" class="form-control" id="doc_id" name="doc_id" placeholder="{{ __('auth.doc_id_placeholder') }}" value="">
						-->
                        @if($errors->has('email'))
                            <p class="text-danger">{{ $errors->first('email') }}</p>
                        @endif
                    </div>					
					
                    <button type="submit" class="btn btn-success btn-block">{{ __('passwords.reset_btn') }}</button>
                    <br>
                    <p class="text-center m-t-xs text-sm">{{ __('passwords.remembered') }}</p>
                    <a href="{{ route('login') }}" class="btn btn-default btn-block m-t-md">{{ __('passwords.back_to_login_btn') }}</a>
                </form>
                <p class="text-center m-t-xs text-sm">
                    {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                </p>
            </div>
        </div>
    </div>

@endsection
