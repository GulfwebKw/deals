<label>{{ $label }}</label>
@if(isset($required)) <span style="color: red">*</span> @endif
<textarea
        class="kt-tinymce-4 form-control  @if($errors->has($name)) is-invalid @endif"
        rows="10"
        name="{{$name}}"
        placeholder="{{ 'Please enter ' . $label }}"
>{{ old($name) ? old($name) : "" }}</textarea>
@if($errors->has($name))
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
@endif