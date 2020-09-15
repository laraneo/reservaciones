@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.wizard.templateTitle') }}
@endsection

@section('title')
    {!! trans('installer_messages.environment.wizard.tabs.app') !!}
@endsection

@section('container')

    <div class="progress">
        <div class="progress-bar progress-bar-animated progress-bar-striped" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">60%</div>
    </div>
    <br><br>

    <form method="post" action="{{ route('LaravelInstaller::environmentSaveWizard') }}" class="tabs-wrap">

        {{ csrf_field() }}

        <div class="row">

            @if(Session::has('db_connection_failed'))
                <div class="col-md-12">
                    <div class="alert alert-danger">{{ session('db_connection_failed') }}</div>
                    <br>
                </div>
            @endif

            <div class="form-group col-md-6">
                <label for="app_name">
                    {{ trans('installer_messages.environment.wizard.form.app_name_label') }}
                </label>
                <input type="text" class="form-control {{ $errors->has('app_name') ? 'is-invalid' : '' }}" name="app_name" id="app_name" value="{{ old('app_name') }}" placeholder="{{ trans('installer_messages.environment.wizard.form.app_name_placeholder') }}" />
                @if ($errors->has('app_name'))
                    <span class="form-text text-danger">
                    {{ $errors->first('app_name') }}
                </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="app_url">
                    {{ trans('installer_messages.environment.wizard.form.app_url_label') }}
                </label>
                <input type="url" class="form-control {{ $errors->has('app_url') ? 'is-invalid' : '' }}" name="app_url" id="app_url" value="{{ isset($_SERVER['HTTPS']) ? 'https://' : 'http://' }}{{ $_SERVER['HTTP_HOST'] }}" placeholder="{{ trans('installer_messages.environment.wizard.form.app_url_placeholder') }}" />
                @if ($errors->has('app_url'))
                    <span class="form-text text-danger">
                    {{ $errors->first('app_url') }}
                </span>
                @endif
            </div>


            <div class="col-md-12">
                <label for="timezone">
                    {{ trans('installer_messages.environment.wizard.form.select_timezone') }}
                </label>
                <select class="form-control" name="timezone">
                    @foreach($timezones as $timezone)
                        <option>{{ $timezone }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-12">
                <br>
                <h2 class="text-center">{!! trans('installer_messages.environment.wizard.tabs.database') !!}</h2>
                <br>
            </div>

            <div class="form-group col-md-12">
                <label for="database_connection">
                    {{ trans('installer_messages.environment.wizard.form.db_connection_label') }}
                </label>
                <select class="form-control" name="database_connection" id="database_connection">
                    <option value="mysql" selected>{{ trans('installer_messages.environment.wizard.form.db_connection_label_mysql') }}</option>
                    <option value="sqlite">{{ trans('installer_messages.environment.wizard.form.db_connection_label_sqlite') }}</option>
                    <option value="pgsql">{{ trans('installer_messages.environment.wizard.form.db_connection_label_pgsql') }}</option>
                    <option value="sqlsrv">{{ trans('installer_messages.environment.wizard.form.db_connection_label_sqlsrv') }}</option>
                </select>
                @if ($errors->has('database_connection'))
                    <span class="form-text text-danger">
                        {{ $errors->first('database_connection') }}
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="database_hostname">
                    {{ trans('installer_messages.environment.wizard.form.db_host_label') }}
                </label>
                <input type="text" class="form-control {{ $errors->has('database_hostname') ? 'is-invalid' : '' }}" name="database_hostname" id="database_hostname" value="127.0.0.1" placeholder="{{ trans('installer_messages.environment.wizard.form.db_host_placeholder') }}" />
                @if ($errors->has('database_hostname'))
                    <span class="form-text text-danger">
                        {{ $errors->first('database_hostname') }}
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="database_port">
                    {{ trans('installer_messages.environment.wizard.form.db_port_label') }}
                </label>
                <input type="number" class="form-control {{ $errors->has('database_port') ? 'is-invalid' : '' }}" name="database_port" id="database_port" value="3306" placeholder="{{ trans('installer_messages.environment.wizard.form.db_port_placeholder') }}" />
                @if ($errors->has('database_port'))
                    <span class="form-text text-danger">
                        {{ $errors->first('database_port') }}
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="database_name">
                    {{ trans('installer_messages.environment.wizard.form.db_name_label') }}
                </label>
                <input type="text" class="form-control {{ $errors->has('database_name') ? 'is-invalid' : '' }}" name="database_name" id="database_name" value="{{ old('database_name') }}" placeholder="{{ trans('installer_messages.environment.wizard.form.db_name_placeholder') }}" />
                @if ($errors->has('database_name'))
                    <span class="form-text text-danger">
                        {{ $errors->first('database_name') }}
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="database_username">
                    {{ trans('installer_messages.environment.wizard.form.db_username_label') }}
                </label>
                <input type="text" class="form-control {{ $errors->has('database_username') ? 'is-invalid' : '' }}" name="database_username" id="database_username" value="{{ old('database_username') }}" placeholder="{{ trans('installer_messages.environment.wizard.form.db_username_placeholder') }}" />
                @if ($errors->has('database_username'))
                    <span class="form-text text-danger">
                        {{ $errors->first('database_username') }}
                    </span>
                @endif
            </div>

            <div class="form-group col-md-12">
                <label for="database_password">
                    {{ trans('installer_messages.environment.wizard.form.db_password_label') }}
                </label>
                <input type="password" class="form-control {{ $errors->has('database_password') ? 'is-invalid' : '' }}" name="database_password" id="database_password" value="" placeholder="{{ trans('installer_messages.environment.wizard.form.db_password_placeholder') }}" />
                @if ($errors->has('database_password'))
                    <span class="form-text text-danger">
                        {{ $errors->first('database_password') }}
                    </span>
                @endif
            </div>

            <div class="col-md-12">
                <br>
                <h2 class="text-center">{!! trans('installer_messages.environment.wizard.tabs.mail') !!}</h2>
                <br>
            </div>

            <div class="form-group col-md-6">
                <label for="mail_driver">
                    {{ trans('installer_messages.environment.wizard.form.app_tabs.mail_driver_label') }}
                </label>
                <input type="text" class="form-control {{ $errors->has('mail_driver') ? 'is-invalid' : '' }}" name="mail_driver" id="mail_driver" value="smtp" placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_driver_placeholder') }}" />
                @if ($errors->has('mail_driver'))
                    <span class="form-text text-danger">
                        {{ $errors->first('mail_driver') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="mail_host">{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_host_label') }}</label>
                <input type="text" class="form-control {{ $errors->has('mail_host') ? 'is-invalid' : '' }}" name="mail_host" id="mail_host" value="{{ old('mail_host') }}"  placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_host_placeholder') }}" />
                @if ($errors->has('mail_host'))
                    <span class="form-text text-danger">
                        {{ $errors->first('mail_host') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="mail_port">{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_port_label') }}</label>
                <input type="number" class="form-control {{ $errors->has('mail_port') ? 'is-invalid' : '' }}" name="mail_port" id="mail_port" value="2525" placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_port_placeholder') }}" />
                @if ($errors->has('mail_port'))
                    <span class="form-text text-danger">
                        {{ $errors->first('mail_port') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="mail_username">{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_username_label') }}</label>
                <input type="text" class="form-control {{ $errors->has('mail_username') ? 'is-invalid' : '' }}" name="mail_username" id="mail_username" value="{{ old('mail_username') }}"  placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_username_placeholder') }}" />
                @if ($errors->has('mail_username'))
                    <span class="form-text text-danger">
                        {{ $errors->first('mail_username') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="mail_password">{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_password_label') }}</label>
                <input type="password" class="form-control {{ $errors->has('mail_password') ? 'is-invalid' : '' }}" name="mail_password" id="mail_password" placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_password_placeholder') }}" />
                @if ($errors->has('mail_password'))
                    <span class="form-text text-danger">
                        {{ $errors->first('mail_password') }}
                    </span>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="mail_encryption">{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_encryption_label') }}</label>
                <input type="text" class="form-control {{ $errors->has('mail_encryption') ? 'is-invalid' : '' }}" name="mail_encryption" id="mail_encryption" value="ssl" placeholder="{{ trans('installer_messages.environment.wizard.form.app_tabs.mail_encryption_placeholder') }}" />
                @if ($errors->has('mail_encryption'))
                    <span class="form-text text-danger">
                        {{ $errors->first('mail_encryption') }}
                    </span>
                @endif
            </div>

            <div class="col-md-12 text-center">
                <br>
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    {{ trans('installer_messages.environment.wizard.form.buttons.install') }}&nbsp;&nbsp;<i class="fa fa-chevron-right"></i>
                </button>
                <br>
            </div>

        </div>

    </form>
@endsection


