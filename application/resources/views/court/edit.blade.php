@extends('layouts.admin', ['title' => __('backend.court_edit')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.court_edit') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('court.index') }}">{{ __('backend.events') }}</a></li>
                <li class="active">{{ __('backend.court_edit') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.court_edit') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-2">
                            <br>
                                <div class="text-center">
                                    <form method="post" action="{{route('court.destroy', $court->id)}}">
                                        {{csrf_field()}}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                        </div>
                                    </form>
                                </div>
                        </div>

                        <div class="col-md-8">
                            <form method="post" action="{{route('court.update', $court->id)}}" enctype="multipart/form-data">

                                {{csrf_field()}}
                                {{ method_field('PATCH') }}

								<input type="hidden" name="id" id="id" value="{{ $court->id }}">

								<div class="form-group{{$errors->has('title') ? ' has-error' : ''}}">
									<label class="control-label" for="title">{{ __('backend.title') }}</label>
									<input type="text" class="form-control" name="title" value="{{$court->title}}">
									@if ($errors->has('title'))
										<span class="help-block">
											<strong class="text-danger">{{ $errors->first('title') }}</strong>
										</span>
									@endif
								</div>

                                <div class="form-group">
                                <label class="control-label" for="package_id">{{ __('backend.package') }}</label>
                                    <select class="form-control" name="package_id">
                                        <option value="">Seleccione</option>
                                        @foreach($packages as $element)
                                            <option value="{{ $element->id }}" {{ $element->id == $court->package_id ? 'selected' : '' }} >{{ $element->title }}</option>
                                        @endforeach
                                    </select>
                                 </div>
								
                                <div class="form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                    <label class="control-label" for="is_active">{{ __('backend.status') }}</label>
                                    <select class="form-control" name="is_active">
                                        @if($court->is_active==1)
                                            <option value="1" selected>{{ __('backend.active') }}</option>
                                            <option value="0">{{ __('backend.disabled') }}</option>
                                        @else
                                            <option value="1">{{ __('backend.active') }}</option>
                                            <option value="0" selected>{{ __('backend.disabled') }}</option>
                                        @endif
                                    </select>
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
