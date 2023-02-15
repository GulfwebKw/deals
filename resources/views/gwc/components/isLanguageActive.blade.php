<div class="form-group">
    <div class="input-group row">
        <label class="col-3">{{ $label }}</label>
        <div class="col-3">
            <span class="kt-switch">
                <label>
                    <input value="1" type="checkbox" id="{{ $name }}" name="{{ $name }}"
                            {{ $value ? 'checked' : '' }}>
                    <span></span>
                </label>
            </span>
        </div>
    </div>
</div>