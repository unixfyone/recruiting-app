<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UploadProfileRequest;
use App\Http\Resources\Profile as ProfileResource;
use App\Http\Resources\ProfileCollection;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Mail\ProfileShare;
use Illuminate\Support\Facades\Mail;


class ProfileController extends Controller
{
    protected $profile;

    public function __construct(Profile $profile){
        $this->profile = $profile;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            new ProfileCollection(
                $this->profile->where('status','Completado')->orderBy('id', 'desc')->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {
        $profileData = $request->all();
        $profileData['birthdate'] = Carbon::parse($request->birthdate)->format('Y-m-d');

        $profile = $this->profile->create($profileData);
        return response()->json(new ProfileResource($profile),201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile): JsonResponse
    {
        return response()->json(
            new ProfileResource($profile)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile): JsonResponse
    {
        $profileData = $request->all();
        $profileData['birthdate'] = Carbon::parse($request->birthdate)->format('Y-m-d');

        $profile->update($profileData);
        return response()->json(new ProfileResource($profile));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile): JsonResponse
    {
        $profile->delete();
        return response()->json(null,204);
    }

    public function profile_max(Profile $profile): JsonResponse
    {
        $conditions = Profile::where('user_id','1')->get();
        return response()->json(
            new ProfileCollection($conditions)
        );

    }

    public function profileByUser(Profile $profile, $user_id): JsonResponse
    {
        $conditions = Profile::where('user_id', $user_id)->get();

        return response()->json(
            new ProfileCollection($conditions)
        );
    }

    public function profilePdfData($profile_id)
    {
        $profiles = Profile::with(['educations','experiences','user'])->where('id',$profile_id)->get();

        $data = [
            'title' => 'Resumen curricular',
            'date' => date('d/m/Y'),
            'profiles' => $profiles,
            'imageURI' => $profiles[0]->user->profile_photo_path,
            'description' => $profiles[0]->description
        ];

        $pdf = PDF::loadView('profile', $data);
        return $pdf->download('profile.pdf');
    }

    public function profileSendMail(Profile $profile, $profile_id) {
        $profile = Profile::where('id',$profile_id)->get();
        Mail::to('mazuaje@petroalianza.com')->send(new ProfileShare($profile));
    }

    public function profileUploadFile(UploadProfileRequest $request, Profile $profile) {
        $getProfileInfo = Profile::where('id', $request->profile_id)->first();

        $path = $request->file('file')->storePubliclyAs('cv',$getProfileInfo->dni.'-'.$request->profile_id.'.pdf','azure');

        $profileData = DB::table('profiles')
                         ->where('id',$request->profile_id)
                         ->update(['uri_cv' => $path]);

        return response()->json(
            'Se a cargado exitosamente el cv'
        );
    }

    public function profilesByFilter(Request $request) {

        $area_interest  = $request->area;
        $status_general = $request->statu;

/*         if(($request->area != "null") && ($request->statu != "null")) {
            $profiles = Profile::whereRaw("JSON_CONTAINS(area_interest, '$request->area')")->where('status_general',$request->statu)->orderBy('id','desc')->get();
        }elseif ($request->statu != "null") {
            $profiles = Profile::where('status_general',$request->statu)->orderBy('id','desc')->get();
        }else {
            $profiles = Profile::whereRaw("JSON_CONTAINS(area_interest, '$request->area')")->orderBy('id','desc')->get();
        } */

        $profiles = Profile::orderBy('id','desc')
            ->statusGeneral($status_general)
            ->areaInterest($area_interest)
            ->get();

        return response()->json(
            new ProfileCollection($profiles)
        );
    }
}
