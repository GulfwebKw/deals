@foreach($categories as $category)
    <option value="{{ $category->id }}">
        @for ($i = 0; $i <= $level; $i++)
            -
        @endfor
        {{ $category->title }}
    </option>
    @if(count($category->childrenRecursive) > 0)
        @include('gwc.partials.category',['categories' => $category->childrenRecursive, 'level'=>($level+1)])
    @endif
@endforeach
