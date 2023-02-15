<label>{{ $label }}</label>
@if(isset($required)) <span style="color: red">*</span> @endif
<input @if(isset($type)) type="{{$type}}" @else type="text" @endif
       class="form-control @if($errors->has($name)) is-invalid @endif"
       name="{{ $name }}"
       placeholder="{{ 'Please enter ' . $label }}"
       value="{{ old($name) ? old($name) : "" }}"
       @if(isset($required)) required @endif
>
@if($errors->has($name))
    <div class="invalid-feedback">
        {{ $errors->first($name) }}
    </div>
@endif