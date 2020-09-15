@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.verifyPurchase.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer_messages.verifyPurchase.title') }}
@endsection

@section('container')

    <div class="progress">
        <div class="progress-bar progress-bar-animated progress-bar-striped" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">40%</div>
    </div>
    <br><br>

    <form method="post" action="{{ route('LaravelInstaller::verifyPurchasePost') }}">
        {{ csrf_field() }}

        @if(Session::has('invalid_code'))
            <div class="alert alert-danger">{{ session('invalid_code') }}</div>
        @endif

        <div class="form-group">
            <label class="control-label" for="purchase_key">Purchase Key</label>
            <input type="text" class="form-control form-control-lg {{ $errors->has('purchase_key') ? 'is-invalid' : '' }}" value="{{ old('purchase_key') }}" name="purchase_key" id="purchase_key">
            @if($errors->has('purchase_key'))
                <p class="form-text text-danger">
                    {{ $errors->first('purchase_key') }}
                </p>
            @endif
        </div>
        <br>
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">
                {{ trans('installer_messages.verifyPurchase.next') }}&nbsp;&nbsp;<i class="fa fa-chevron-right"></i>
            </button>
        </div>
    </form>


@endsection
