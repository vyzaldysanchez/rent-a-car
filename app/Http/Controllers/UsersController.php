<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();

        if ($users->count()) {
            return $this->success($users);
        }

        return $this->noContent();
    }

    public function display(User $user): JsonResponse
    {
        return $this->success($user);
    }

    public function store(Request $request): JsonResponse
    {
        $user = User::create($request->all());
        return $this->created($user);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $user->update($request->all());
        return $this->success($user);
    }

    public function delete(User $user): JsonResponse
    {
        $user->delete();
        return $this->noContent();
    }
}
