@extends(Auth::user()->isAdmin() ? 'layouts.admin' : 'layouts.customer', ['title' => __('backend.change_password')])
@section('content')

    <div class="page-title">
        <h3>{{ __('backend.change_password') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.change_password') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin-top:15px;">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.set_new_password') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">

                        @include('alerts.customerPassword')

                        @if($errors->has('password'))
                            <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                        @endif

                            <form method="post" action="{{ route('postChangePassword', Auth::user()->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label class="control-label">{{ __('backend.new_password') }}</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{ __('backend.confirm_password') }}</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('backend.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection