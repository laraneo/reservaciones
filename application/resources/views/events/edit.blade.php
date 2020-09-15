@extends('layouts.admin', ['title' => __('backend.edit_event')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.edit_event') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('events.index') }}">{{ __('backend.events') }}</a></li>
                <li class="active">{{ __('backend.edit_event') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.edit_event') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-2">
                            <br>
                                <div class="text-center">
                                    <form method="post" action="{{route('events.destroy', $event->id)}}">
                                        {{csrf_field()}}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                        </div>
                                    </form>
                                </div>
                        </div>

                        <div class="col-md-8">
                            <form method="post" action="{{route('events.update', $event->id)}}" enctype="multipart/form-data">

                                {{csrf_field()}}
                                {{ method_field('PATCH') }}

								<input type="hidden" name="id" id="id" value="{{ $event->id }}">

								<div class="form-group{{$errors->has('date') ? ' has-error' : ''}}">
									<label class="control-label" for="date">{{ __('backend.date') }}</label>
									<input type="date" class="form-control" name="date" value="{{$event->date}}">
									@if ($errors->has('date'))
										<span class="help-block">
											<strong class="text-danger">{{ $errors->first('date') }}</strong>
										</span>
									@endif
								</div>
								

                                    <div class="form-group{{$errors->has('time1') ? ' has-error' : ''}}">
                                        <label class="control-label" for="time1">{{ __('backend.time1') }}</label>
                                        <input type="time" class="form-control" name="time1" value="{{$event->time1}}">
                                        @if ($errors->has('time1'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('time1') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{$errors->has('time2') ? ' has-error' : ''}}">
                                        <label class="control-label" for="time2">{{ __('backend.time2') }}</label>
                                        <input type="time" class="form-control" name="time2" value="{{$event->time2}}">
                                        @if ($errors->has('time2'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('time2') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                 @if($event->event_type == "2")
                                    <div class="form-group{{$errors->has('drawtime1') ? ' has-error' : ''}}">
                                        <label class="control-label" for="drawtime1">{{ __('backend.drawtime1') }}</label>
                                        <input type="datetime-local" class="form-control" name="drawtime1" value="{{ str_replace(' ', 'T', $event->drawtime1) }}">
                                        @if ($errors->has('drawtime1'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('drawtime1') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{$errors->has('drawtime2') ? ' has-error' : ''}}">
                                        <label class="control-label" for="drawtime2">{{ __('backend.drawtime2') }}</label>
                                        <input type="datetime-local" class="form-control" name="drawtime2" value="{{str_replace(' ', 'T', $event->drawtime2) }}">
                                        @if ($errors->has('drawtime2'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('drawtime2') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                 @endif

                                <div class="form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                    <label class="control-label" for="description">{{ __('backend.description') }}</label>
                                    <input type="text" class="form-control" name="description" value="{{$event->description}}">
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                    <label class="control-label" for="is_active">{{ __('backend.status') }}</label>
                                    <select class="form-control" name="is_active">
                                        @if($event->is_active==1)
                                            <option value="1" selected>{{ __('backend.active') }}</option>
                                            <option value="0">{{ __('backend.disabled') }}</option>
                                        @else
                                            <option value="1">{{ __('backend.active') }}</option>
                                            <option value="0" selected>{{ __('backend.disabled') }}</option>
                                        @endif
                                    </select>
                                </div>
                            
                            <div class="form-group">
                                <label class="control-label" for="event_type">{{ __('backend.type') }}</label>
                                <select class="form-control" name="event_type" disabled>
                                    <option value={{$event->event_type}} selected>{{$event->event_type == "2" ? 'Sorteo' : 'Evento'}}</option>
                                </select>
                                <input type="hidden" name="event_type" value={{$event->event_type}}>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="internal">{{ __('backend.use') }}</label>
                                <select class="form-control" name="internal" disabled>
                                    <option value={{$event->internal}} selected>{{$event->internal == "0" ? 'General' : 'Interno'}}</option>
                                </select>
                                <input type="hidden" name="internal" value={{$event->internal}}>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="category_id">{{ __('backend.category') }}</label>
                                <select class="form-control" name="category_id">
                                    <option value="">Seleccione</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $event->category_id ? 'selected' : '' }} >{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.update_event') }}</button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
