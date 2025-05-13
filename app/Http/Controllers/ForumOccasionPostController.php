<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumOccasionPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForumOccasionPostController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'give_kudos' => 'required',
            'position' => 'required',
            'certification' => 'required',
            'work_anniversary' => 'required',
            'education_milestone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        } else {
            $userId = Auth::id();
            $data = [
                'user_id' => $userId,
                'give_kudos' => $request->give_kudos,
                'position' => $request->position,
                'certification' => $request->certification,
                'work_anniversary' => $request->work_anniversary,
                'education_milestone' => $request->education_milestone,
            ];

            DB::beginTransaction();
            try {
                $Post = ForumOccasionPost::create($data);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                echo $e->getMessage();
                $Post = null;
            }

            if ($Post != null) {
                return response()->json([
                    'message' => 'Occasion Celebrate Post Successfully',
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
