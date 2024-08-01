@extends('layout.master')

@section('title', 'لیست کاربران')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ردیف</th>
            <th scope="col">نام کاربر</th>
            <th scope="col">ایمیل کاربر</th>
            <th scope="col">تاریخ ثبت نام</th>
            <th scope="col">نقش</th>
            @if(Auth::user()->hasRole(['admin']))
                <th scope="col">عملیات</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <?php
                    $data = [];
                foreach($user->roles as $role)
                {
                    $data[] = $role['name'];
                }
                $str = implode(", ",$data);
                ?>
{{--                @dd($user)--}}

                <td>{{ $str }}</td>
                @if(Auth::user()->hasRole(['admin']))
                    <td>
                        <a href="{{ route('user.edit', ['user' => $user->id]) }}" type="button" class="btn btn-primary">ویرایش نقش</a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
