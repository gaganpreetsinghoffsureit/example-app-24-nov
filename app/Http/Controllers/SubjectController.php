<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
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


        $query = Subject::query()->with("semester");

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

        return ResponseHelper::success(__("message.subject-show-all-success"), $universities);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $subject = new Subject();
        $subject->fill($request->validated());
        $subject->saveOrFail();
        return ResponseHelper::success(__("message.subject-store-success"), $subject);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->course = $subject->course;
        return ResponseHelper::success(__("message.subject-show-success"), $subject);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->fill($request->validated());
        $subject->verified_at = null;
        $subject->saveOrFail();
        return ResponseHelper::success(__("message.subject-update-success"), $subject);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->deleteOrFail();
        return ResponseHelper::success(__("message.subject-delete-success"), null);
    }
}
