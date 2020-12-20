<div class="form-group row">
    <select class="custom-select col-4" name="contact_type_id">
        @foreach($contactTypes as $t)
        <option 
            value="{{ $t->id }}" 
            {{ old('contact_type_id', $contact->contact_type_id) == $t->id?'selected="selected"':'' }}
        >{{ $t->name }}</option>
        @endforeach
    </select>
    
    <input 
        id="data" type="text" 
        class="form-control col-8 @error('data') is-invalid @enderror" 
        name="data" value="{{ old('data', $contact->data) }}" 
        required autofocus
    >

    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>