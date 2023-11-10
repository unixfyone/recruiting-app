<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailManager;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use Iluminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new UserCollection(
                $this->user->orderBy('id','desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(
            new UserResource($user)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function getListUsers() {
        $usersList = EmailManager::with('user')->get();

        return response()->json($usersList);
    }
}
