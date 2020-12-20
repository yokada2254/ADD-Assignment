<div class="form-row form-group">
    <div class="col-2">
        <label for="block">{{ __('property.block') }}</label>
        <input 
            id="block" type="text" name="block" 
            class="form-control text-center @error('block') is-invalid @enderror" 
            value="{{ old('block', @$property->block) }}"
            {{ @$disabled }}
        />
    </div>
    <div class="col-2">
        <label for="floor">{{ __('property.floor') }}</label>
        <input 
            id="floor" type="text" name="floor" 
            class="form-control text-center @error('floor') is-invalid @enderror" 
            value="{{ old('floor', @$property->floor) }}"
            {{ @$disabled }}                             
        />
    </div>
    <div class="col-2">
        <label for="flat">{{ __('property.flat') }}</label>
        <input 
            id="flat" type="text" name="flat" 
            class="form-control text-center @error('flat') is-invalid @enderror" 
            value="{{ old('flat', @$property->flat) }}"
            {{ @$disabled }}
        />
    </div>
    <div class="col-4">
        <label for="flat">{{ __('property.open_kitchen') }}</label>
        <div class="form-check">
            <input 
                id="open_kitchen" type="checkbox" name="open_kitchen" 
                class="form-check-input" value="1" 
                {{ old('open_kitchen', @$property->open_kitchen) == '1'?'checked="checked"':'' }} 
                {{ @$disabled }}
            />
            <label for="open_kitchen" class="form-check-label">{{ __('form.yes') }}</label>
        </div>
    </div>
</div>

<div class="form-row form-group">
    <div class="col-2">
        <label for="gross_size">{{ __('property.gross_size') }}</label>
        <div class="input-group">
            <input 
                id="gross_size" type="text" name="gross_size" 
                class="form-control text-right @error('gross_size') is-invalid @enderror" 
                value="{{ old('gross_size', @$property->gross_size) }}"
                {{ @$disabled }}
            />
            <div class="input-group-append">
                <span class="input-group-text">{!! __('property.ft_square') !!}</span>
            </div>
        </div>
    </div>
    <div class="col-2">
        <label for="room">{{ __('property.room') }}</label>
        <input 
            id="room" type="text" name="room" 
            class="form-control text-right @error('room') is-invalid @enderror" 
            value="{{ old('room', @$property->room) }}"
            {{ @$disabled }}
        />
    </div>
    <div class="col-2">
        <label for="washroom">{{ __('property.washroom') }}</label>
        <input 
            id="washroom" type="text" name="washroom" 
            class="form-control text-right @error('washroom') is-invalid @enderror" 
            value="{{ old('washroom', @$property->washroom) }}"
            {{ @$disabled }}
        />
    </div>
    <div class="col-2">
        <label for="store_room">{{ __('property.store_room') }}</label>
        <input 
            id="store_room" type="text" name="store_room" 
            class="form-control text-right @error('store_room') is-invalid @enderror" 
            value="{{ old('store_room', @$property->store_room) }}"
            {{ @$disabled }}
        />
    </div>
    <div class="col-2">
        <label for="roof_size">{{ __('property.roof') }}</label>
        <div class="input-group">
            <input 
                id="roof_size" type="text" name="roof_size" 
                class="form-control text-right @error('roof_size') is-invalid @enderror" 
                value="{{ old('roof_size', @$property->roof_size) }}"
                {{ @$disabled }}
            />
            <div class="input-group-append">
                <span class="input-group-text">{!! __('property.ft_square') !!}</span>
            </div>
        </div>
    </div>
    <div class="col-2">
        <label for="balcony_size">{{ __('property.balcony') }}</label>
        <div class="input-group">
            <input 
                id="balcony_size" type="text" name="balcony_size" 
                class="form-control text-right @error('balcony_size') is-invalid @enderror" value="{{ old('balcony_size', @$property->balcony_size) }}"
                {{ @$disabled }}
            />
            <div class="input-group-append">
                <span class="input-group-text">{!! __('property.ft_square') !!}</span>
            </div>
        </div>
    </div>
</div>

<people 
    data-title="{{ __('property.owner') }}" 
    data-items="{{ json_encode(isset($property)?$property->owners:[]) }}"
    data-disabled="{{ empty($disabled)?'':'true' }}"
></people>