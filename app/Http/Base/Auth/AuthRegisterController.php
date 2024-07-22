<?php

namespace DDD\Http\Base\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use DDD\Http\Base\Auth\Requests\AuthRegisterRequest;
use DDD\Domain\Users\User;
use DDD\Domain\Organizations\Resources\OrganizationResource;
use DDD\Domain\Organizations\Organization;
use DDD\App\Controllers\Controller;

class AuthRegisterController extends Controller
{
    public function __invoke(AuthRegisterRequest $request): JsonResponse
    {
        $organization = Organization::create([
            'title' => $request->organization_title,
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'editor', // TODO: Remove
            'organization_id' => $organization->id,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'data' => [
                'access_token' => $token,
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'organization' => new OrganizationResource($user->organization),
            ],
        ], 200);
    }
}
