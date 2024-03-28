@extends('layout.master')

@section('title', 'ساخت دسته بندی جدید')

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
    <form action="{{ route('category.store') }}" method="post">
        @csrf
        <div  class="mb-3">
            <label for="category-title" class="form-label">:نام دسته بندی</label>
            <input id="category-title" name="title" value="{{ old('title') }}" type="text" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">ثبت</button>
    </form>
@endsection
