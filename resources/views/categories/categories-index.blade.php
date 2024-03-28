@extends('layout.master')

@section('title', 'لیست دسته بندی ها')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">نام دسته بندی</th>
            <th scope="col">عملیات</th>
        </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $category->title }}</td>
                    <td>
                        <a href="{{ route('category.edit', ['category' => $category->id]) }}" type="button" class="btn btn-primary">ویرایش</a>
                        <a href="{{ route('category.destroy', ['category' => $category->id]) }}" onclick="return confirm('are you sure?')" class="btn btn-danger">حذف</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
