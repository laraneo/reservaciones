@extends('layouts.admin', ['title' => __('backend.edit_addon')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.edit_addon') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('addons.index') }}">{{ __('backend.addons') }}</a></li>
                <li class="active">{{ __('backend.edit_addon') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.edit_addon') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('addons.update', $addon->id)}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            {{ method_field('PATCH') }}

                            <div class="col-md-6 form-group{{$errors->has('title') ? ' has-error' : ''}}">
                                <label class="control-label" for="title">{{ __('backend.title') }}</label>
                                <input type="text" class="form-control" name="title" value="{{ $addon->title }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('price') ? ' has-error' : ''}}">
                                <label class="control-label" for="price">{{ __('backend.price') }}</label>
                                <input type="text" class="form-control" name="price" value="{{ $addon->price }}">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                <label class="control-label" for="category_id">{{ __('backend.category') }}</label>
                                <select class="form-control" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $addon->category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">{{ __('backend.description') }}</label>
                                <textarea name="description" class="summernote">{{ $addon->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                                <label for="photo_id" class="control-label">{{ __('backend.select_image') }}</label>
                                <input type="file" id="photo_id" name="photo_id">
                                @if ($errors->has('photo_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block">
                                    <strong class="text-info">{{ __('backend.package_image_info') }}</strong>
                                </span>
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.update_addon') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection