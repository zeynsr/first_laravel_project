@extends('layout.master')
@section('title', 'لیست کاربران')

@section('content')

    <form action="{{ route('user.update', ['user' => $user->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="user_name" class="form-label">نام کاربر:</label>
            <input id="user_namee" name="name" value="{{ old('name', $user->name) }}" type="text"
                   class="form-control">
        </div>
        <div class="mb-3">
            <label for="user_email" class="form-label">ایمیل:</label>
            <input id="user_email" name="email" value="{{ old('email', $user->email) }}" type="email"
                   class="form-control">
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">تصویر پروفایل:</label><br>
            <input type="file" name="profile_image" accept="image/*">
        </div>
        @if(Auth::user()->hasRole(['admin']))
            <label for="name-tag" class="form-label">نقش ها:</label>
            @foreach($roles as $role)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="roles[]" type="checkbox" id="roles{{ $role->id }}"
                           value="{{ $role->id }}" @checked(in_array($role->id, $roles_ids ))>
                    <label class="form-check-label" for="roles{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @endforeach
        @endif
        <br>
        <button type="submit" class="btn btn-primary">ثبت</button>
    </form>
@endsection
