<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\University;
use Illuminate\Http\Request;

class CourseController extends Controller
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


        $query = Course::query()->with("university");

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

        return ResponseHelper::success(__("message.course-show-all-success"), $universities);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $course = new Course();
        $course->fill($request->validated());
        $course->saveOrFail();
        return ResponseHelper::success(__("message.course-store-success"), $course);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->university = $course->university;
        return ResponseHelper::success(__("message.course-show-success"), $course);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->fill($request->validated());
        $course->verified_at = null;
        $course->saveOrFail();
        return ResponseHelper::success(__("message.course-update-success"), $course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->deleteOrFail();
        return ResponseHelper::success(__("message.course-delete-success"), null);
    }
}
