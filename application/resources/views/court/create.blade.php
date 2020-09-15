@extends('layouts.admin', ['title' => __('backend.court_add')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.court_add') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('court.index') }}">{{ __('backend.courts') }}</a></li>
                <li class="active">{{ __('backend.court_add') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
    {{ $typeTest ? $typeTest : '-' }}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.court_add') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('court.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

                            <div class="form-group{{$errors->has('title') ? ' has-error' : ''}}">
								<label class="control-label" for="title">{{ __('backend.title') }}</label>
								<input type="text" class="form-control" name="title">
								@if ($errors->has('title'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('title') }}</strong>
									</span>
								@endif
							</div>

                            <div class="form-group{{$errors->has('package_id') ? ' has-error' : ''}}">
                                <label class="control-label" for="package_id">{{ __('backend.package') }}</label>
                                <select class="form-control" name="package_id">
                                    <option value="">Seleccione</option>
                                    @foreach($packages as $element)
                                        <option value="{{ $element->id }}">{{ $element->title }}</option>
                                    @endforeach
                                </select>
                            </div>

							<div class="form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                <label class="control-label" for="is_active">{{ __('backend.status') }}</label>
                                <select class="form-control" name="is_active">
                                    <option value="1">{{ __('backend.active') }}</option>
                                    <option value="0">{{ __('backend.disabled') }}</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.create') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>    
    
        function onSelecType() {
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            const id = document.getElementById("event_type").value;
            if(id == 0) {
                $('#drawtimelist').empty();
            } else {
                $.ajax({
                type: 'GET',
                url: "/get-draw-times",
                    success: function(response) {
                        $('#drawtimelist').html(response);;  
                    },
                });
            }
            
        }
    
    </script>

@endsection
