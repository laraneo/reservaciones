@extends('layouts.admin', ['title' => __('backend.packages_types_edit')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.packages_types_edit') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li>{{ __('backend.package') }}</li>
                <li class="active">{{ __('backend.packages_types_edit') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.packages_types_edit') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-2">
                            <br>
                                <div class="text-center">
                                    <form method="post" action="{{route('packages-types.destroy', $court->id)}}">
                                        {{csrf_field()}}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                        </div>
                                    </form>
                                </div>
                        </div>

                        <div class="col-md-8">
                            <form method="post" action="{{route('packages-types.update', $court->id)}}" enctype="multipart/form-data">

                                {{csrf_field()}}
                                {{ method_field('PATCH') }}

                                <div class="row" style="line-height: 2.5;">
                                
                                
                                <div class="col-md-1 form-group"> {{ __('backend.title') }}  </div>
                                <div class="col-md-5 form-group{{$errors->has('title') ? ' has-error' : ''}}">
                                    <input type="text" class="form-control" name="title" value="{{$court->title}}">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-1 form-group"> {{ __('backend.alias') }}  </div>
                                <div class="col-md-5 form-group{{$errors->has('alias') ? ' has-error' : ''}}">
                                    <input type="text" class="form-control" name="alias" value="{{$court->alias}}">
                                    @if ($errors->has('alias'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('alias') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-1 form-group"> {{ __('backend.package') }} </div>
                            <div class="col-md-5 form-group{{$errors->has('package_id') ? ' has-error' : ''}}">
                                <select class="form-control" name="package_id">
                                    <option value="">Seleccione</option>
                                    @foreach($packages as $element)
                                        <option value="{{ $element->id }}" {{ $element->id == $court->package_id ? 'selected' : '' }} >{{ $element->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('package_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('package_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                            
                                <div class="col-md-3 form-group" style="margin-left: -15px;"> {{ __('backend.package_time') }}  </div>
                                <div class="col-md-5 form-group{{$errors->has('length') ? ' has-error' : ''}}">
                                    <input type="number" class="form-control" name="length" value="{{$court->length}}">
                                    @if ($errors->has('length'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('length') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-4 form-group" >{{ __('backend.minutes') }}</div>

                            </div>

                            <div class="col-md-6">
                            
                                <div class="row">
                                
                                    <div class="col-md-2 form-group"> {{ __('backend.status') }}  </div>
                                    <div class="col-md-10 form-group">
                                        <select class="form-control" name="status" >
                                            <option value="" >Seleccione</option>
                                            <option value="0" {{ $court->status == 0 ? 'selected' : '' }}>{{ __('backend.disabled') }}</option>
                                            <option value="1" {{ $court->status == 1 ? 'selected' : '' }}>{{ __('backend.active') }}</option>
                                        </select>
                                    </div>
                                
                                </div>

                            </div>



                            <div class="col-md-12 form-group">
                                <div class="row">
                                    <div class="col-md-2 form-group"> {{ __('backend.booking') }} </div>
                                    <div class="col-md-1 form-group">Min</div>
                                    <div class="col-md-1 form-group{{$errors->has('booking_min') ? ' has-error' : ''}}">
                                        <input type="number" class="form-control" name="booking_min" value="{{$court->booking_min}}">
                                        @if ($errors->has('booking_min'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('booking_min') }}</strong>
                                            </span>
								        @endif
                                    </div>
                                    <div class="col-md-1 form-group">Max</div>
                                    <div class="col-md-1 form-group{{$errors->has('booking_max') ? ' has-error' : ''}}">
                                        <input type="number" class="form-control" name="booking_max" value="{{$court->booking_max}}">
                                        @if ($errors->has('booking_max'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('booking_max') }}</strong>
                                            </span>
								        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <div class="row">
                                    <div class="col-md-2 form-group"> {{ __('backend.user') }} </div>
                                    <div class="col-md-1 form-group">Min</div>
                                    <div class="col-md-1 form-group{{$errors->has('player_min') ? ' has-error' : ''}}">
                                        <input type="number" class="form-control" name="player_min" value="{{$court->player_min}}">
                                        @if ($errors->has('player_min'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('player_min') }}</strong>
                                            </span>
								        @endif
                                    </div>
                                    <div class="col-md-1 form-group">Max</div>
                                    <div class="col-md-1 form-group{{$errors->has('player_max') ? ' has-error' : ''}}">
                                        <input type="number" class="form-control" name="player_max" value="{{$court->player_max}}">
                                        @if ($errors->has('player_max'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('player_max') }}</strong>
                                            </span>
								        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12 form-group">
                                <div class="row">
                                    <div class="col-md-2 form-group"> {{ __('backend.guest') }} </div>
                                    <div class="col-md-1 form-group">Min</div>
                                    <div class="col-md-1 form-group form-group{{$errors->has('guest_min') ? ' has-error' : ''}}">
                                        <input type="number" class="form-control" name="guest_min" value="{{$court->guest_min}}">
                                        @if ($errors->has('guest_min'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('guest_min') }}</strong>
                                            </span>
								        @endif
                                    </div>
                                    <div class="col-md-1 form-group">Max</div>
                                    <div class="col-md-1 form-group form-group{{$errors->has('guest_max') ? ' has-error' : ''}}">
                                        <input type="number" class="form-control" name="guest_max" value="{{$court->guest_max}}">
                                        @if ($errors->has('guest_max'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('guest_max') }}</strong>
                                            </span>
								        @endif
                                    </div>
                                </div>
                            </div>

								<input type="hidden" name="id" id="id" value="{{ $court->id }}">

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.update') }}</button>
                                </div>
                                
                                
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
