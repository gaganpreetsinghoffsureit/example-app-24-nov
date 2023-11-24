<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StorePaperRequest;
use App\Http\Requests\UpdatePaperRequest;
use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaperController extends Controller
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


        $query = Paper::query()->with(["subject.semester.course.university"]);

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

        return ResponseHelper::success(__("message.paper-show-all-success"), $universities);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaperRequest $request)
    {
        $paper = new Paper();
        $paper->fill($request->validated());
        $paper->user_id = Auth::user()->id;
        $paper->saveOrFail();
        return ResponseHelper::success(__("message.paper-store-success"), $paper);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paper $paper)
    {
        $paper->course = $paper->course;
        return ResponseHelper::success(__("message.paper-show-success"), $paper);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaperRequest $request, Paper $paper)
    {
        $paper->fill($request->validated());
        $paper->verified_at = null;
        $paper->saveOrFail();
        return ResponseHelper::success(__("message.paper-update-success"), $paper);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paper $paper)
    {
        $paper->deleteOrFail();
        return ResponseHelper::success(__("message.paper-delete-success"), null);
    }
}
