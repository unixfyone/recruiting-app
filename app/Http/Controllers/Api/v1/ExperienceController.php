<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Http\Resources\Experience as ExperienceResource;
use App\Http\Resources\ExperienceCollection;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;


class ExperienceController extends Controller
{
    protected $experience;

    public function __construct(Experience $experience){
        $this->experience = $experience;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new ExperienceCollection(
                $this->experience->orderBy('id','desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExperienceRequest $request): JsonResponse
    {
        $experienceData = $request->all();
        $experienceData['date_from'] = Carbon::parse($request->date_from)->format('Y-m-d');
        $experienceData['date_to']   = Carbon::parse($request->date_to)->format('Y-m-d');

        $experience = $this->experience->create($experienceData);
        return response()->json(new ExperienceResource($experience),201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience): JsonResponse
    {
        return response()->json(
            new ExperienceResource($experience)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceRequest $request, Experience $experience): JsonResponse
    {
        $experienceData = $request->all();
        $experienceData['date_from'] = Carbon::parse($request->date_from)->format('Y-m-d');
        $experienceData['date_to']   = Carbon::parse($request->date_to)->format('Y-m-d');

        $experience->update($experienceData);
        return response()->json(new ExperienceResource($experience));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience): JsonResponse
    {
        $experience->delete();
        return response()->json(null,204);
    }

    public function experienceByProfile(Experience $experience, $profile_id){
        $conditions = Experience::where('profile_id', $profile_id)
        ->orderBy('id','desc')->get();

        return response()->json(
            new ExperienceCollection($conditions)
        );
    }
}
