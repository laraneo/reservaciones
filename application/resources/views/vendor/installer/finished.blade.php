@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.final.templateTitle') }}
@endsection



@section('title')
    <br>
    {{ trans('installer_messages.final.title') }}

    <br><br>
    <div class="progress">
        <div class="progress-bar progress-bar-animated progress-bar-striped" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">100%</div>
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

@endsection

@section('container')

	<p class="text-center">{!! trans('installer_messages.final.text') !!}</p>

	<div class="text-center">
        <br><br>
        <a class="btn btn-primary btn-lg" href="{{ route('login') }}">{{ trans('installer_messages.final.login_btn') }}</a>
        <a class="btn btn-dark btn-lg" href="{{ route('index') }}">{{ trans('installer_messages.final.home_btn') }}</a>
        <br><br>
    </div>

@endsection
