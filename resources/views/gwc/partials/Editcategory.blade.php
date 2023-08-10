@foreach($categories as $category)
    <option @if(
    isset($notSelectable) &&
      is_array($notSelectable) &&
       in_array($category->id, $notSelectable->toArray())) disabled @endif
    value="{{ $category->id }}"
            @if(isset($parent_id)
 and ( ( !  is_int($parent_id) and
 in_array($category->id, $parent_id->toArray())) or
  ( is_int($parent_id) and $category->id==$parent_id )  )
  )
                selected @endif>
        @for ($i = 0; $i <= $level; $i++)
            -
        @endfor
        {{ $category->title }}
    </option>
    @if(count($category->childrenRecursive) > 0)
        @include('gwc.partials.Editcategory',['categories' => $category->childrenRecursive, 'parent_id'=>$parent_id, 'notSelectable'=>isset($notSelectable)?$notSelectable:null,'level'=>($level+1), 'category_id'=>$category_id])
    @endif
@endforeach
