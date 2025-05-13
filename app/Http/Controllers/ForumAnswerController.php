<?php

namespace App\Http\Controllers;

use App\Models\ForumAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForumAnswerController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responseCode' => '400',
                'responseMessage' => $validator->errors()->first(),
                'responseType' => 'error'
            ], 200);
        }

        try {
            $query = DB::table('forum_answer')
                ->join('users', 'forum_answer.user_id', '=', 'users.id')
                ->where('forum_answer.question_id', $request->question_id)
                ->select(
                    'forum_answer.id',
                    'users.name',
                    'users.profile',
                    'forum_answer.answer',
                    'forum_answer.image',
                    'forum_answer.created_at'
                )
                ->orderBy('forum_answer.created_at', 'desc');

            $perPage = $request->perpage ?? 15; // Number of items per page
            $paginatedData = $query->paginate($perPage);

            $response = [
                'responseCode' => '200',
                'responseType' => 'success',
                'data' => $paginatedData->items(),
                'pagination' => [
                    'total' => $paginatedData->total(),
                    'per_page' => $paginatedData->perPage(),
                    'current_page' => $paginatedData->currentPage(),
                    'last_page' => $paginatedData->lastPage(),
                ],
            ];

            return response()->json($response, 200);

        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json([
                'responseCode' => '401',
                'responseMessage' => 'An error occurred: ' . $e->getMessage(),
                'responseType' => 'error'
            ], 200);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
            'answer' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'responseCode' => '400',
                'responseMessage' => $validator->errors()->first(),
                'responseType' => 'success'
            ],
                200);
        } else {
            $userId = Auth::id();

            // Handle file upload
            if ($request->hasFile('image')) {
                $filename = time() . "_answer." . $request->file('image')->getClientOriginalExtension();

                // Store file in public/uploads directory
                $request->file('image')->storeAs('uploads', $filename, 'public');
                $file_path = 'uploads/' . $filename; // Save path to the database
            } else {
                $file_path = null;
            }

            $data = [
                'user_id' => $userId,
                'question_id' => $request->question_id,
                'answer' => $request->answer,
                'image' => $file_path,
            ];

            DB::beginTransaction();
            try {
                $answer = ForumAnswer::create($data);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                echo $e->getMessage();
                $answer = null;
            }

            if ($answer != null) {
                return response()->json([
                    'responseCode' => '200',
                    'responseMessage' => 'Forum Answer added Successfully',
                    'responseType' => 'success',
                ], 200);
            } else {
                return response()->json([
                    'responseCode' => '401',
                    'responseMessage' => 'Internal Server Error',
                    'responseType' => 'fail',
                ], 200);
            }
        }
    }
}
