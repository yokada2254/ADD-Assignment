<div class="card-footer d-flex justify-content-center">
    <button class="btn btn-sm btn-primary m-1" type="submit"><i class="fas fa-save mr-1"></i>{{ __('form.save') }}</button>
    <a class="btn btn-sm btn-secondary m-1" href="{{ Request::url() }}"><i class="fas fa-redo-alt mr-1"></i>{{ __('form.reset') }}</a>
    <a class="btn btn-sm btn-danger m-1" href="{{ $url??'/' }}"><i class="fas fa-times mr-1"></i>{{ __('form.cancel') }}</a>
</div>