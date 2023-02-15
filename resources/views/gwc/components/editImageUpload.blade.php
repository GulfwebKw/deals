<div class="col-md-8">
    <label>{{ $label }}</label>
    @if(isset($required)) <span style="color: red">*</span> @endif
    <div class="custom-file @if($errors->has($name)) is-invalid @endif">
        <input type="file"
               class="custom-file-input @if($errors->has($name)) is-invalid @endif"
               id="{{$name}}"
               name="{{$name}}"
               @if($value != null) value="{{ $value }}" @endif
               @if(isset($required) && $value == null) required @endif
        >
        <label class="custom-file-label" for="{{$name}}">
            Choose Image (JPG,JPEG,PNG,GIF) , 2MB
        </label>
    </div>
    @if($errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
</div>
<div class="col-md-4">
    @if($value)
        <img src="{!! asset($folder . $value) !!}" style="max-width:100%">

        @if(isset($deletePath))
        <a href="javascript:;"
           data-toggle="kt-popover"
           data-trigger="focus"
           title="Alert"
           data-html="true"
           data-content="Are you sure you want to delete?<br><br><a href='{{url($deletePath)}}' class='btn btn-brand btn-danger btn-icon-sm btn-sm'>Yes</a>"
           class="btn btn-brand btn-danger btn-icon-sm btn-sm"
        >
            <i class="la la-trash"></i>
            Delete
        </a>
        @endif

    @endif
</div>