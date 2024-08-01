<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UpdateUserRequest;

class UserProfileController extends Controller
{
    use FileUploadTrait;
    function update(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'user_id' => ['required', 'string', 'max:50', 'unique:users,user_name,'.auth()->user()->id],
            'email' => ['required', 'email', 'max:100'],
        ]);


        $avatarPath = $this->uploadFile($request, 'avatar');

        $user = Auth::user();

        if ($avatarPath) {
            $user->avatar = $avatarPath;
        }

        $user->name = $request->name;
        $user->user_name = $request->user_id;
        $user->email = $request->email;

        if ($request->filled('current_password')) {

            $request->validate([
                'current_password' => ['required', 'current_password', 'bail'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            $user->password = bcrypt($request->password);
        }
        $user->save();

        notyf()->addSuccess('updated Successfully');
        return response(['message' => 'Updated Successfully!'], 200);


        // $avatarPath = $this->uploadFile($request, 'avatar');

        // $user = Auth::user();
        // if($avatarPath) $user->avatar = $avatarPath;
        // $user->name = $request->name;
        // $user->user_name = $request->user_id;
        // $user->email = $request->email;
        // if($request->filled('current_password')) {
        //     $request->validate([
        //         'current_password' => ['required', 'current_password'],
        //         'password' => ['required', 'string', 'min:8', 'confirmed']
        //     ]);
        //     $user->password = bcrypt($request->password);
        // }
        // $user->save();

        // notyf()->addSuccess('Updated Successfully.');

        // return response(['message' => 'Updated Successfully!'], 200);

    }
}
