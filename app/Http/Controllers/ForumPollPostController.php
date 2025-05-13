<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumPollPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForumPollPostController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'duration' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        } else {
            $userId = Auth::id();



            $data = [
                'user_id' => $userId,
                'question' => $request->question,
                'option_1' => $request->option_1,
                'option_2' => $request->option_2,
                'option_3' => $request->option_3,
                'option_4' => $request->option_4,
                'duration' => $request->duration,

            ];

            DB::beginTransaction();
            try {
                $Poll = ForumPollPost::create($data);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                echo $e->getMessage();
                $Poll = null;
            }

            if ($Poll != null) {
                return response()->json([
                    'message' => 'Forum Poll added Successfully',
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
