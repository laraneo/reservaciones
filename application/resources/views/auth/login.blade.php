@extends('layouts.login', ['title' => __('auth.page_title')])

@section('content')

    <div class="row">
        <div class="col-md-3 center">
            <div class="login-box">
                <p style="text-align:center;">
                    <a href="{{ route('index') }}" class="logo-name text-lg text-center"><img src="{{ asset('images/logo-dark.png') }}" class="img-responsive"></a>
                </p>
                <p class="text-center m-t-md">{{ __('auth.login_title') }}</p>

                @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif

                <form class="m-t-md" method="post" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('auth.email_placeholder') }}" value="{{ old('email') }}" autofocus>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('auth.password_placeholder') }}">
                    </div>

                    <button type="submit" class="btn btn-success btn-block">{{ __('auth.login_btn') }}</button>

                    <br>
					
                    <p class="text-center m-t-xs text-sm">{{ __('auth.forgot_password_title') }}</p>
                    <a href="{{ route('password.request') }}" class="btn btn-default btn-block m-t-md">{{ __('auth.forgot_password_btn') }}</a>

                   <p class="text-center m-t-xs text-sm hidden">{{ __('auth.custom_password_reset_title') }}</p>
                    <a href="custom/PasswordReset.php" class="btn btn-default btn-block m-t-md">{{ __('auth.custom_forgot_password_btn') }}</a>					
					
                </form>
                <p class="text-center m-t-xs text-sm">
                    {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                </p>
            </div>
        </div>
    </div>

@endsection

