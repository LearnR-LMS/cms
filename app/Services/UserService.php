<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService extends BaseService
{
    public function login($request)
    {
        $auth_data = [
            "email" => $request->input('email'),
            "password" => $request->input('password'),
        ];
        // Authenticate
        if (!$token = JWTAuth::attempt($auth_data))
            abort(400, 'Tài khoản hoặc mật khẩu không đúng.');

        return [
            'token' => 'Bearer ' . $token
        ];
    }
    public function refresh()
    {
        $token = JWTAuth::getToken();
        return [
            'token' => 'Bearer ' . JWTAuth::refresh($token),
        ];
        // return [
        //     'token' => 'Bearer ' . JWTAuth::parseToken()->refresh(),
        // ];
    }
    public function store($request)
    {
        $input = [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
        ];
        $user = User::create($input);
        $user->roles()->attach([1]);
        return $input;
    }
    public function update($id, $request)
    {
        $id = (int) $id;
        $user = User::find($id);
        if ($user) {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->save();
        } else {
            abort(404, "Không tìm thấy user");
        }
        return $request->all();
    }
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $user->roles()->detach();
        } else {
            abort(404, "Không tìm thấy user");
        }

        return $id;
    }
}