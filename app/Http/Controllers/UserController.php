<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\Role;
//use Illuminate\Foundation\Auth\User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('users.users-index', compact('users', 'roles'));
    }

    public function edit(User $user)
    {
        $data = [
            'user' => $user,
            'roles' => Role::all(),
            'roles_ids' => $user->getRolesIds()
        ];
        return view('users.users-edit', $data);
    }

    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        } else {
            $user->roles()->detach();
        }
        $user->save();

        return redirect()->route('user.index');
    }

//    public function assignRole(Request $request, $userId)
//    {
//        $user = User::findOrFail($userId);
//        $roles = $request->input('roles'); // درخواست شامل آرایه‌ای از نقش‌ها
//
//        // اختصاص نقش‌های موردنظر به کاربر
//        $user->syncRoles($roles);
//
//        return redirect()->route('users.index')->with('success', 'نقش‌ها با موفقیت به کاربر اختصاص داده شدند.');
//    }



}
