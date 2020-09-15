    <div class="form-group{{$errors->has('drawtime1') ? ' has-error' : ''}}">
        <label class="control-label" for="drawtime1">{{ __('backend.drawtime1') }}</label>
        <input type="datetime-local" class="form-control" name="drawtime1" value="06:00 AM">
        @if ($errors->has('drawtime1'))
            <span class="help-block">
                <strong class="text-danger">{{ $errors->first('drawtime1') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{$errors->has('drawtime2') ? ' has-error' : ''}}">
        <label class="control-label" for="drawtime2">{{ __('backend.drawtime2') }}</label>
        <input type="datetime-local" class="form-control" name="drawtime2" value="06:00 PM">
        @if ($errors->has('drawtime2'))
            <span class="help-block">
                <strong class="text-danger">{{ $errors->first('drawtime2') }}</strong>
            </span>
        @endif
    </div>