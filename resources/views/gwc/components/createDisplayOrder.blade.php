<input
        type="number"
        class="form-control @if($errors->has('display_order')) is-invalid @endif"
        name="display_order"
        value="{{old('display_order') ? old('display_order') : $lastOrder }}"
        autocomplete="off"
        min="0"
        required
/>
@if($errors->has('display_order'))
    <div class="invalid-feedback">{{ $errors->first('display_order') }}</div>
@endif