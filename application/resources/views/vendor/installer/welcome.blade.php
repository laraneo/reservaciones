@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.welcome.templateTitle') }}
@endsection

@section('title')
    <br>
    {{ trans('installer_messages.welcome.title') }}
@endsection

@section('container')
    <p class="text-center">
      {{ trans('installer_messages.welcome.message') }}
    </p>
    <br><br>
    <p class="text-center">
      <a href="{{ route('LaravelInstaller::requirements') }}" class="btn btn-primary btn-lg">
        {{ trans('installer_messages.welcome.next') }}&nbsp;&nbsp;<i class="fa fa-chevron-right"></i>
      </a>
    </p>
    <br><br>
@endsection
