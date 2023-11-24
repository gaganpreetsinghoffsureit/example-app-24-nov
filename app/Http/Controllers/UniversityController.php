<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreUniversityRequest;
use App\Http\Requests\UpdateUniversityRequest;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validation
        $request = $request->validate([
            'name' => 'string',
            'address' => 'string',
            'zip_code' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
            'verified_at' => 'date',
            'created_at' => 'date',
            'updated_at' => 'date',
        ]);


        $query = University::query();

        $where = [];
        // Apply filters
        foreach ($request as $key => $value) {
            if ($value !== null) {
                $where[] = [$key, "like", "%" . $value . "%"];
            }
        }


        if (count($where))
            $where = $query->where($where);



        // Get paginated results
        $universities = $query->paginate(10);

        return ResponseHelper::success(__("message.university-show-all-success"), $universities);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUniversityRequest $request)
    {
        $university = new University();
        $university->fill($request->validated());
        $university->saveOrFail();
        return ResponseHelper::success(__("message.university-store-success"), $university);
    }

    /**
     * Display the specified resource.
     */
    public function show(University $university)
    {
        return ResponseHelper::success(__("message.university-show-success"), $university);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUniversityRequest $request, University $university)
    {
        $university->fill($request->validated());
        $university->verified_at = null;
        $university->saveOrFail();
        return ResponseHelper::success(__("message.university-update-success"), $university);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(University $university)
    {
        $university->deleteOrFail();
        return ResponseHelper::success(__("message.university-delete-success"), null);
    }
}
