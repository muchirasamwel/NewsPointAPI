<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function show($id): Http
    {
        $user = User::find($id);

        return Http::success($user);
    }

    public function store(StoreUserRequest $request): Http
    {
        $user = User::create($request->toArray());

        return Http::success(
            $user,
            Response::HTTP_CREATED
        );
    }

    public function update(UpdateUserRequest $request): Http
    {
        $user = User::find($request->get('id'));
        $user->update($request->except('email', 'id'));

        return Http::success(
            $user,
            Response::HTTP_ACCEPTED
        );
    }

    public function destroy($id): Http | response
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                "message" => 'User not found',
                "data" => null
            ], Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return Http::success();
    }
}
