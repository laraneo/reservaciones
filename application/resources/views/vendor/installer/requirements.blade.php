@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.requirements.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer_messages.requirements.title') }}
@endsection

@section('container')

    @foreach($requirements['requirements'] as $type => $requirement)
        <div class="alert alert-{{ $phpSupportInfo['supported'] ? 'success' : 'danger' }}">
            <strong>{{ ucfirst($type) }}</strong>
            @if($type == 'php')
                <strong>
                    <small>
                        (version {{ $phpSupportInfo['minimum'] }} required)
                    </small>
                </strong>
                <span class="float-right">
                    <strong>
                        {{ $phpSupportInfo['current'] }}
                    </strong>
                    &nbsp;&nbsp;
                    <i class="far fa-{{ $phpSupportInfo['supported'] ? 'check-circle text-success' : 'times-circle text-danger' }}"></i>
                </span>

            @endif
        </div>
        <ul class="list-group">
            @foreach($requirements['requirements'][$type] as $extention => $enabled)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $extention }}
                    <i class="far fa-{{ $enabled ? 'check-circle text-success' : 'times-circle text-danger' }}"></i>
                </li>
            @endforeach
        </ul>
        <br>
    @endforeach

    @if ( !isset($requirements['errors']) && $phpSupportInfo['supported'] )
        <div class="text-center">
            <a class="btn btn-primary btn-lg" href="{{ route('LaravelInstaller::permissions') }}">
                {{ trans('installer_messages.requirements.next') }}&nbsp;&nbsp;<i class="fa fa-chevron-right"></i>
            </a>
        </div>
    @else
        <div class="text-center">
            <a class="btn btn-primary btn-lg" href="{{ route('LaravelInstaller::requirements') }}">
                <i class="fas fa-sync"></i>&nbsp;&nbsp;{{ trans('installer_messages.requirements.refresh') }}
            </a>
        </div>
    @endif

@endsection