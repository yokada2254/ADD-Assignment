<div class="card">
    <div class="card-header">
        <h4>{{ __('privilege.title') }}</h4>
    </div>
    <div class="card-body">
        <ul class="list-group">
        @foreach($privileges as $privilege)
            <div class="list-group-item">
                <div class="custom-control custom-switch">
                    <input 
                        type="checkbox" class="custom-control-input" 
                        id="privilege-{{ $privilege->id }}" name="privilege_id[]" 
                        value="{{ $privilege->id }}"
                        {{ $role->privileges->contains($privilege->id)?'checked':'' }}
                        {{ @$disabled }}
                    />
                    <label 
                        class="custom-control-label" 
                        for="privilege-{{ $privilege->id }}">{{ $privilege->name }}
                    </label>
                </div> 
            </div>
        @endforeach
        </ul>
    </div>
    <div class="card-footer"></div>
</div>