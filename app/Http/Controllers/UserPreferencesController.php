<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPreferencesRequest;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class UserPreferencesController extends Controller
{
    public function update(UserPreferencesRequest $request): response
    {
        $user = User::find($request->get('user_id'));
        if (!$user) {
            return Http::error('User not found', null, Response::HTTP_NOT_FOUND);
        }
        $user->user_preferences = $request->get('user_preferences');
        $user->save();

        return Http::success($user, Response::HTTP_ACCEPTED);
    }
}
