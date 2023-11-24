<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validation
        $request = $request->validate([
            'name' => 'string',
        ]);


        $query = Semester::query()->with("course");

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

        return ResponseHelper::success(__("message.semester-show-all-success"), $universities);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSemesterRequest $request)
    {
        $semester = new Semester();
        $semester->fill($request->validated());
        $semester->saveOrFail();
        return ResponseHelper::success(__("message.semester-store-success"), $semester);
    }

    /**
     * Display the specified resource.
     */
    public function show(Semester $semester)
    {
        $semester->course = $semester->course;
        return ResponseHelper::success(__("message.semester-show-success"), $semester);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSemesterRequest $request, Semester $semester)
    {
        $semester->fill($request->validated());
        $semester->verified_at = null;
        $semester->saveOrFail();
        return ResponseHelper::success(__("message.semester-update-success"), $semester);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        $semester->deleteOrFail();
        return ResponseHelper::success(__("message.semester-delete-success"), null);
    }
}
