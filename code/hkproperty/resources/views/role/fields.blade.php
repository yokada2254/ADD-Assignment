<div class="form-row my-2">
    <div class="col-12">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <div class="input-group-text">{{ __('role.name') }}</div>
            </div>
            <input type="text" class="form-control" name="name" value="{{ Request::old('name', @$role->name) }}" {{ @$disabled }} />
        </div>
    </div>
</div>