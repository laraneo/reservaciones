@extends('layouts.admin', ['title' => __('backend.add_new_event')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.add_new_event') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('events.index') }}">{{ __('backend.events') }}</a></li>
                <li class="active">{{ __('backend.add_new_event') }}</li>
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
                            <h4 class="panel-title">{{ __('backend.add_new_event') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('events.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}

						
						  
                            <div class="form-group{{$errors->has('description') ? ' has-error' : ''}}">
								<label class="control-label" for="description">{{ __('backend.description') }}</label>
								<input type="text" class="form-control" name="description">
								@if ($errors->has('description'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('description') }}</strong>
									</span>
								@endif
							</div>

                            <div class="form-group{{$errors->has('event_type') ? ' has-error' : ''}}">
                                <label class="control-label" for="event_type">{{ __('backend.type') }}</label>
                                <select class="form-control" name="event_type" id="event_type" onchange="onSelecType()">
                                    <option value="0">{{ __('backend.reservation') }}</option>
                                    <option value="2">{{ __('backend.draw') }}</option>
                                </select>
                            </div>

                            <div class="form-group{{$errors->has('date') ? ' has-error' : ''}}">
                                <label class="control-label" for="category_id">{{ __('backend.category') }}</label>
                                <select class="form-control" name="category_id">
                                    <option value="">Seleccione</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group{{$errors->has('date') ? ' has-error' : ''}}">
								<label class="control-label" for="date">{{ __('backend.date') }}</label>
								<input type="date" class="form-control" name="date">
								@if ($errors->has('date'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('date') }}</strong>
									</span>
								@endif
							</div>

							<div class="form-group{{$errors->has('time1') ? ' has-error' : ''}}">
								<label class="control-label" for="time1">{{ __('backend.time1') }}</label>
								<input type="time" class="form-control" name="time1" value="06:00 AM">
								@if ($errors->has('time1'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('time1') }}</strong>
									</span>
								@endif
							</div>
							
							<div class="form-group{{$errors->has('time2') ? ' has-error' : ''}}">
								<label class="control-label" for="time2">{{ __('backend.time2') }}</label>
								<input type="time" class="form-control" name="time2" value="06:00 PM">
								@if ($errors->has('time2'))
									<span class="help-block">
										<strong class="text-danger">{{ $errors->first('time2') }}</strong>
									</span>
								@endif
							</div>

                            <div id="drawtimelist"> </div>

							<div class="form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                <label class="control-label" for="is_active">{{ __('backend.status') }}</label>
                                <select class="form-control" name="is_active">
                                    <option value="1">{{ __('backend.active') }}</option>
                                    <option value="0">{{ __('backend.disabled') }}</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.create_event') }}</button>
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
