@extends('layout.master')

@section('title', 'ادیت پست')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('post.update', ['post' => $post->id]) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="post-title" class="form-label">عنوان پست:</label>
            <input id="post-title" name="title" value="{{ old('title', $post->title) }}" type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label for="name-tag"  class="form-label">محتوای پست:</label>
            <div>
                <textarea class="form-control" name="content" >{{ $post->content }}</textarea>
            </div>
        </div>
        <div class="mb-3">
            <label for="post-short_content" class="form-label">محتوای کوتاه پست:</label>
            <input id="post-short_content" name="short_content" value="{{ old('short_content', $post->short_content) }}" type="text" class="form-control">
        </div>
        <div>
            <label for="category_id"  class="form-label">نام دسته بندی:</label>
            <select name="category_id" class="form-select">
                <option value="">انتخاب کنید:</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected($category->id == $post->category_id)>{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <button type="submit"  class="btn btn-primary">ثبت</button>
    </form>
@endsection
