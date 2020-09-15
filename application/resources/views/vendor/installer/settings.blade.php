@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.settings.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer_messages.settings.title') }}
@endsection

@section('container')

    <form method="post" action="{{ route('LaravelInstaller::saveSettings') }}">
        {{ csrf_field() }}

        @if(count($errors))
            <div class="alert alert-danger">Check form for possible errors.</div>
        @endif

        <div class="progress">
            <div class="progress-bar progress-bar-animated progress-bar-striped" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">80%</div>
        </div>
        <br><br>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Business Name</label>
                    <input type="text" class="form-control {{ $errors->has('business_name') ? 'is-invalid' : '' }}"
                           name="business_name" value="{{ old('business_name') }}">
                    @if($errors->has('business_name'))
                        <p class="form-text text-danger">{{ $errors->first('business_name') }}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Currency</label>
                    <select class="form-control {{ $errors->has('default_currency') ? 'is-invalid' : '' }}"
                            name="default_currency">
                        <option value="0">Select One</option>
                        <option value="USD">US Dollar</option>
                        <option value="GBP">British Pound</option>
                        <option value="EUR">Euro</option>
                        <option value="CAD">Canadian Dollar</option>
                        <option value="AUD">Australian Dollar</option>
                        <option value="SGD">Singapore Dollar</option>
                        <option value="SEK">Swedish Krona</option>
                        <option value="HKD">Hong Kong Dollar</option>
                        <option value="CHF">Swiss Frank</option>
                        <option value="JPY">Japanese Yen</option>
                        <option value="ARS">Argentine Peso</option>
                        <option value="BRL">Brazilian Real</option>
                        <option value="DKK">Danish Krone</option>
                        <option value="INR">Indian Rupee</option>
                        <option value="MXN">Mexican Peso</option>
                        <option value="NZD">New Zealand Dollar</option>
                        <option value="NOK">Norwegian Krone</option>
                        <option value="RUB">Russian Rubble</option>
                        <option value="TRY">Turkish Lira</option>
                    </select>
                    @if($errors->has('default_currency'))
                        <p class="form-text text-danger">{{ $errors->first('default_currency') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">Select Default Language</label>
            <select class="form-control {{ $errors->has('lang') ? 'is-invalid' : '' }}"
                    name="lang">
                <option value="0">Select One</option>
                <option value="en">English</option>
                <option value="es">Spanish</option>
                <option value="fr">French</option>
                <option value="pt">Portuguese</option>
                <option value="it">Italian</option>
                <option value="de">German</option>
                <option value="da">Danish</option>
            </select>
            @if($errors->has('lang'))
                <p class="form-text text-danger">{{ $errors->first('lang') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label">Business Email</label>
            <input type="text" class="form-control {{ $errors->has('contact_email') ? 'is-invalid' : '' }}"
                   name="contact_email" value="{{ old('contact_email') }}">
            @if($errors->has('contact_email'))
                <p class="form-text text-danger">{{ $errors->first('contact_email') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label">Business Phone</label>
            <input type="text" class="form-control {{ $errors->has('contact_number') ? 'is-invalid' : '' }}"
                   name="contact_number" value="{{ old('contact_number') }}">
            @if($errors->has('contact_number'))
                <p class="form-text text-danger">{{ $errors->first('contact_number') }}</p>
            @endif
        </div>
        <br><hr><br>
        <h5 class="text-center">Administrator Account</h5>
        <p class="text-center">Please provide details to create administrator account.</p>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">First Name</label>
                    <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                           name="first_name" value="{{ old('first_name') }}">
                    @if($errors->has('first_name'))
                        <p class="form-text text-danger">{{ $errors->first('first_name') }}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Last Name</label>
                    <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                           name="last_name" value="{{ old('last_name') }}">
                    @if($errors->has('last_name'))
                        <p class="form-text text-danger">{{ $errors->first('last_name') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">Email Address</label>
            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                   name="email" value="{{ old('email') }}">
            @if($errors->has('email'))
                <p class="form-text text-danger">{{ $errors->first('email') }}</p>
            @endif
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password">
                </div>
                @if($errors->has('password'))
                    <p class="form-text text-danger">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Confirm Password</label>
                    <input type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" name="password_confirmation">
                </div>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Finalize & Login&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></button>
        <br>
    </form>

@endsection