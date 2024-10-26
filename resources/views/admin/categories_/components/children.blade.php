@foreach ($categories as $category)
    <div class="form-check" style="margin-left: {{ $category->parent_id ? '20px' : '0px' }};">
        <input type="checkbox" class="form-check-input category-checkbox" id="category{{ $category->id }}"
            name="parent_id[]" value="{{ $category->id }}"
            data-children="{{ $category->children->pluck('id')->toJson() }}"
            @if (isset($selectedCategories) && in_array($category->id, $selectedCategories)) checked @endif> <!-- Đánh dấu nếu đã chọn -->
        <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
    </div>
    @if ($category->children->isNotEmpty())
        @include('admin.categories_.components.children', ['categories' => $category->children, 'selectedCategories' => isset($selectedCategories) ? $selectedCategories : []]) <!-- Truyền mảng selectedCategories vào children -->
    @endif
@endforeach
