<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function login(LoginRequest $request): response
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return Http::error(
                'Invalid credentials!',
                null,
                Response::HTTP_UNAUTHORIZED
            );
        }
        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('_token', $token, 60 * 5); // 5 hours

        return Http::success(null)->withCookie($cookie);
    }

    public function account(): response
    {
        $user = Auth::user();
        return Http::success($user);
    }

    public function logout(): response
    {
        $cookie = Cookie::forget('_token');

        return Http::success()->withCookie($cookie);
    }

    public function show($id): response
    {
        $user = User::find($id);

        return Http::success($user);
    }

    public function store(StoreUserRequest $request): response
    {
        $user = User::create($request->toArray());

        return Http::success(
            $user,
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateUserRequest $request): response
    {
        $user = User::find($request->get('id'));
        $user->update($request->except('email', 'id'));

        return Http::success(
            $user,
            Response::HTTP_ACCEPTED
        );
    }

    public function destroy($id): response
    {
        $user = User::find($id);

        if (!$user) {
            return Http::error('User not found', null, Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return Http::success();
    }
}
