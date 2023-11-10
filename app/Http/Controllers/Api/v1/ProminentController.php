<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Prominent;
use App\Http\Requests\StoreProminentRequest;
use App\Http\Requests\UpdateProminentRequest;
use App\Http\Resources\Prominent as ProminentResource;
use App\Http\Resources\ProminentCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProminentController extends Controller
{
    protected $prominent;

    public function __construct(Prominent $prominent) {
        $this->prominent = $prominent;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new ProminentCollection(
                $this->prominent->orderBy('id','desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProminentRequest $request): JsonResponse
    {
        $prominent = $this->prominent->create($request->all());
        return response()->json(new ProminentResource($prominent), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Prominent $prominent): JsonResponse
    {
        return response()->json(
            new ProminentResource($prominent)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProminentRequest $request, Prominent $prominent)
    {
        $prominent->update($request->all());
        return response()->json(new ProminentResource($prominent));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prominent $prominent)
    {
        $prominent->delete();
        return response()->json(null, 204);
    }

    public function prominentByProfile(Prominent $prominent, $profile_id) {
        $conditions = Prominent::where('profile_id', $profile_id)
        ->orderBy('id','desc')->get();

        return response()->json(
            new ProminentCollection($conditions)
        );
    }
}
