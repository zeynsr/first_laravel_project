@extends('layout.master')

@section('title', 'لیست پست ها')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">عنوان پست</th>
            <th scope="col">محتوای پست</th>
            <th scope="col">محتوای کوتاه پست</th>
            <th scope="col">دسته بندی</th>
            <th scope="col">نویسنده</th>
            <th scope="col">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $post->title }}</td>
                <td>{{ mb_substr($post->content, 0, 20) . ' ...' }}</td>
                <td>{{ $post->short_content }}</td>
                <td>{{ $post->category->title }}</td>
                <td>{{ $post->user_id }}</td>
                <td>
                    <a href="{{ route('post.edit', ['post' => $post->id]) }}" type="button" class="btn btn-primary">ویرایش</a>
                    <a href="{{ route('post.destroy', ['post' => $post->id]) }}" onclick="return confirm('are you sure?')" class="btn btn-danger">حذف</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
