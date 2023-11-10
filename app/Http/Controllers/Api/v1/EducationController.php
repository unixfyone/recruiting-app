<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Http\Resources\Education as EducationResource;
use App\Http\Resources\EducationCollection;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class EducationController extends Controller
{
    protected $education;

    public function __construct(Education $education){
        $this->education = $education;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            new EducationCollection(
                $this->education->orderBy('id', 'desc')->get()
            )
        );
    }

    public function store(StoreEducationRequest $request): JsonResponse
    {
        $educationData = $request->all();
        $educationData['date_from'] = Carbon::parse($request->date_from)->format('Y-m-d');
        $educationData['date_to']   = Carbon::parse($request->date_to)->format('Y-m-d');

        $education = $this->education->create($educationData);
        return response()->json(new EducationResource($education),201);
    }

    public function show(Education $education): JsonResponse
    {
        return response()->json(
            new EducationResource($education)
        );
    }

    public function update(UpdateEducationRequest $request, Education $education): JsonResponse
    {
        $educationData = $request->all();
        $educationData['date_from'] = Carbon::parse($request->date_from)->format('Y-m-d');
        $educationData['date_to']   = Carbon::parse($request->date_to)->format('Y-m-d');

        $education->update($educationData);
        return response()->json(new EducationResource($education));
    }

    public function destroy(Education $education): JsonResponse
    {
        $education->delete();
        return response()->json(null,204);
    }

    public function educationByProfile(Education $education, $profile_id){
        $conditions = Education::where('profile_id', $profile_id)->get();

        return response()->json(
            new EducationCollection($conditions)
        );
    }
}
