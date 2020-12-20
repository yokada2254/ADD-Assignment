<div class="card-body">
    <property-fields 
        data-fields="{{ json_encode(['area', 'district', 'estate_type']) }}"
        data-area="{{ old('area_id', @$estate->district->area_id) }}"
        data-district="{{ old('district_id', @$estate->district_id) }}"
        data-estate-type="{{ old('estate_type_id', @$estate->estate_type_id) }}"
        data-disabled="{{ !empty(@$disabled) }}"
    >
    </property-fields>

    <div class="form-row">
        <div class="col-md-4">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <div class="input-group-text">{{ __('estate.name') }}</div>
                </div>
                <input 
                    type="text" value="{{ old('name', $estate->name) }}" 
                    class="form-control @error('name') is-invalid @enderror" 
                    id="input-name" placeholder="{{ __('estate.name') }}" 
                    name="name"
                    autofocus
                    {{ @$disabled }}
                >
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        

        <div class="col-md-8">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <div class="input-group-text">{{ __('estate.address') }}</div>
                </div>
                <input 
                    type="text" value="{{ old('address', $estate->address) }}" 
                    class="form-control @error('address') is-invalid @enderror" 
                    id="input-address" placeholder="{{ __('estate.address') }}" 
                    name="address"
                    autofocus
                    {{ @$disabled }}
                >
                @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>