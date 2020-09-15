@extends('layouts.admin', ['title' => __('backend.edit_category')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.edit_category') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('categories.index') }}">{{ __('backend.categories') }}</a></li>
                <li class="active">{{ __('backend.edit_category') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.edit_category') }}</h4>
                    </div>
                    <div class="panel-body">

                        <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            {{ method_field('PATCH') }}

                            <div class="form-group{{$errors->has('title') ? ' has-error' : ''}}">
                                <label class="control-label" for="title">{{ __('backend.title') }}</label>
                                <input type="text" class="form-control" name="title" value="{{ $category->title }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                             <div class="form-group{{$errors->has('category_type') ? ' has-error' : ''}}">
                                    <label class="control-label" for="category_type">{{ __('backend.category_type') }}</label>
                                    <select class="form-control" name="category_type">
                                        <option value="0" {{ $category->category_type == 0 ? 'selected' : '' }}>Estandar</option>
                                        <option value="1" {{ $category->category_type == 1 ? 'selected' : '' }}>Por tiempo</option>
                                    </select>
                            </div>
                            <div class="form-group{{$errors->has('draw') ? ' has-error' : ''}}">
                                    <label class="control-label" for="draw">{{ __('backend.draw') }}</label>
                                    <select class="form-control" name="draw">
                                        <option value="0" {{ $category->draw == 0 ? 'selected' : '' }}>NO</option>
                                        <option value="1" {{ $category->draw == 1 ? 'selected' : '' }}>SI</option>
                                    </select>
                            </div>

                            <div class="form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                    <label class="control-label" for="is_active">{{ __('backend.status') }}</label>
                                    <select class="form-control" name="is_active">
                                        <option value="0" {{ $category->is_active == 0 ? 'selected' : '' }}>Inactivo</option>
                                        <option value="1" {{ $category->is_active == 1 ? 'selected' : '' }}>Activo</option>
                                    </select>
                            </div>


                            <div class="form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                                <label for="photo_id" class="control-label">{{ __('backend.select_image') }}</label>
                                <input type="file" id="photo_id" name="photo_id">
                                @if ($errors->has('photo_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block">
                                    <strong class="text-info">{{ __('backend.category_image_info') }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.edit_category') }}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection