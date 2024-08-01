{{--@include('sweetalert::alert')--}}

@extends('layout.master')

@section('title', 'لیست پست ها')

@section('content')
    @if (session('msg'))
        <div class="alert alert-success">
            {{ session('msg') }}
        </div>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">عنوان پست</th>
            <th scope="col">محتوای پست</th>
            <th scope="col">محتوای کوتاه پست</th>
            <th scope="col">دسته بندی</th>
            <th scope="col">نویسنده</th>
            @if(Auth::user()->hasRole(['admin', 'owner']))
                <th scope="col">عملیات</th>
            @endif
            @if(Auth::user()->hasRole(['admin']))
                <th scope="col">تایید پست</th>
            @endif
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
                    @if(Auth::user()->hasRole(['admin', 'owner']))
                        <a href="{{ route('post.edit', ['post' => $post->id]) }}" type="button" class="btn btn-primary">ویرایش</a>
                        <a href="{{ route('post.destroy', ['post' => $post->id]) }}" onclick="return confirm('are you sure?')" class="btn btn-danger">حذف</a>
                    @endif
                </td>
                <td>
                    @if(Auth::user()->hasRole(['admin']))
                        @if($post->is_confirm == 0)
                            <a href="{{ route('post.confirm', ['post' => $post->id]) }}" type="button" class="btn btn-success" >تایید</a>
                        @else
                            <a href="{{ route('post.confirm', ['post' => $post->id]) }}" type="button" class="btn btn-danger">رد</a>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
