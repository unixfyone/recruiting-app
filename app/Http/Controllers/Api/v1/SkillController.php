<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Http\Resources\Skill as SkillResource;
use App\Http\Resources\SkillCollection;

class SkillController extends Controller
{
    protected $skill;

    public function __construct(Skill $skill) {
        $this->skill = $skill;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new SkillCollection(
                $this->skill->orderBy('id','desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request): JsonResponse
    {
        $skill = $this->skill->create($request->all());
        return response()->json(new SkillResource($skill), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return response()->json(
            new  SkillResource($skill)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $skill->update($request->all());
        return response()->json(new SkillResource($skill));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill): JsonResponse
    {
        $skill->delete();
        return response()->json(null, 204);
    }

    public function skillByProfile(Skill $skill, $profile_id) {
        $conditions = Skill::where('profile_id', $profile_id)
        ->orderBy('id','desc')->get();

        return response()->json(
            new SkillCollection($conditions)
        );
    }
}
