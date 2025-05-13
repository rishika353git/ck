<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumHiringPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForumHiringPostController extends Controller
{
    public function index(){
        $jobs = ForumHiringPost::get();
        if (count($jobs) > 0) {
            $response = [
                'message' => count($jobs) . ' jobs found',
                'status' => 'success',
                'data' => $jobs,
            ];
        } else {
            $response = [
                'message' => count($jobs) . ' jobs found',
                'status' => 'fail',

            ];
        }
        return response()->json($response, 200);
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'job_title' => 'required',
            'entity_name' => 'required',
            'workplace' => 'required',
            'job_location' => 'required',
            'job_description' => 'required',
            'job_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        } else {
            $userId = Auth::id();
            $data = [
                'user_id' => $userId,
                'job_title' => $request->job_title,
                'entity_name' => $request->entity_name,
                'workplace' => $request->workplace,
                'job_location' => $request->job_location,
                'job_description' => $request->job_description,
                'job_type' => $request->job_type,
            ];

            DB::beginTransaction();
            try {
                $Post = ForumHiringPost::create($data);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                echo $e->getMessage();
                $Post = null;
            }

            if ($Post != null) {
                return response()->json([
                    'message' => 'Occasion Hiring Post Successfully',
                    'status' => 'success',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Internal Server Error',
                    'status' => 'fail',
                ], 500);
            }
        }

    }


}
