<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

    <div class="col-md-6">
        <input 
            id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
            name="name" value="{{ old('name', $people->name) }}" autofocus
        >

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

    <div class="col-md-6 d-flex align-items-center">
        <div class="form-check form-check-inline">
            <input id="gender_M" class="form-check-input" type="radio" name="gender" value="M" {{ old('gender', $people->gender) == 'M'?'checked="checked"':'' }}/>
            <label class="form-check-label" for="gender_M">M</label>
        </div>
        <div class="form-check form-check-inline">
            <input id="gender_F" class="form-check-input" type="radio" name="gender" value="F" {{ old('gender', $people->gender) == 'F'?'checked="checked"':'' }}/>
            <label class="form-check-label" for="gender_F">F</label>
        </div>
        @error('gender')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="hkid" class="col-md-4 col-form-label text-md-right">{{ __('HKID') }}</label>

    <div class="col-md-6">
        <input 
            id="hkid" type="text" class="form-control @error('hkid') is-invalid @enderror" 
            name="hkid" value="{{ old('hkid', $people->hkid) }}"
        >

        @error('hkid')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

@foreach($errors as $error)
<div>{{$errror}}</div>
@endforeach