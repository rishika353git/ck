<?php

namespace App\Http\Controllers;

use App\Models\ForumQuestion;
use App\Models\Forum;
use App\Models\FourmQuestionReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForumQuestionController extends Controller
{

    public function forumcategory(){

        // form Category fetch
        $Category = Forum::select('id', 'name')->where('status',1)->get();
        if (count($Category) > 0) {
            $response = [
                'responseCode' => '200',
                'responseMessage' => count($Category) . ' Category found',
                'responseType' => 'success',
                'data' => $Category,
            ];
        } else {
            $response = [
                'responseCode' => '200',
                'responseMessage' => count($Category) . ' Question found',
                'responseType' => 'success',
                'data'=> []

            ];
        }
        return response()->json($response, 200);
    }

    public function index(Request $request)
    {
        try {
            // Get the current user ID
            $userId = Auth::id();

            // Query to fetch the questions along with user reactions
            $question = DB::table('forum_question')
                ->join('users', 'forum_question.user_id', '=', 'users.id')
                ->join('forum', 'forum_question.categories', '=', 'forum.id')
                ->leftJoin('forum_question_reaction as reaction', function($join) use ($userId) {
                    $join->on('forum_question.id', '=', 'reaction.question_id')
                         ->where('reaction.user_id', '=', $userId);
                })
                ->select(
                    'forum_question.id',
                    'users.name as username',
                    'users.profile as userprofile',
                    'forum_question.title',
                    'forum.name as categories',
                    'forum_question.file',
                    'forum_question.upvote',
                    'forum_question.downvote',
                    'forum_question.created_at',
                    DB::raw('IFNULL(reaction.status, 2) as current_user_reaction')
                )
                ->orderBy('forum_question.created_at', 'desc'); // Order by creation date in descending order

            $perPage = $request->perpage ?? 15; // Number of items per page
            $paginatedData = $question->paginate($perPage);

            // Prepare the response
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
            'title' => 'required|unique:forum_question,title',
            'categories' => 'required',
            'file' => 'required|file|mimes:jpeg,jpg,png,pdf',
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
            if ($request->hasFile('file')) {
                $filename = time() . "_question." . $request->file('file')->getClientOriginalExtension();

                // Store file in public/uploads directory
                $request->file('file')->storeAs('uploads', $filename, 'public');
                $file_path = 'uploads/' . $filename; // Save path to the database
            } else {
                $file_path = null;
            }

            $data = [
                'user_id' => $userId,
                'title' => $request->title,
                'categories' => $request->categories,
                'file' => $file_path,
            ];

            DB::beginTransaction();
            try {
                $question = ForumQuestion::create($data);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $question = null;
            }

            if ($question != null) {
                return response()->json([
                    'responseCode' => '200',
                    'responseMessage' => 'Forum Question added Successfully',
                    'responseType' => 'success',
                ], 200);
            } else {
                return response()->json([
                    'responseCode' => '401',
                    'responseMessage' => $e->getMessage(),
                    'responseType' => 'success',
                ], 200);
            }
        }
    }

    public function bycategories(Request $request)
    {

        $id = $request->categories_id;

        $data = ForumQuestion::where('categories',$id)->get();
        if (count($data) > 0) {
            $response = [
                'message' => count($data) . ' Question found',
                'status' => 'success',
                'data' => $data,
            ];
        } else {
            $response = [
                'message' => count($data) . ' Question found',
                'status' => 'fail',

            ];
        }
        return response()->json($response, 200);

    }

    public function reaction(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
            'status' => 'required|in:0,1,2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responseCode' => '400',
                'responseMessage' => $validator->errors()->first(),
                'responseType' => 'success'
            ],
                200);
        }
        // Get user ID
        $userId = Auth::id();

        // Get post ID and new status from request
        $questionId = $request->question_id;
        $newStatus = $request->status;

        DB::beginTransaction();

        try {
            // Fetch the post
            $question = ForumQuestion::findOrFail($questionId);

            // Fetch the latest reaction of the user for the question
            $existingRecord = FourmQuestionReaction::where('user_id', $userId)
                ->where('question_id', $questionId)
                ->latest('created_at')
                ->first();
            // Check if the existing record's status matches the new status
            if ($existingRecord && $existingRecord->status == $newStatus) {
                return response()->json([
                    'responseCode' => '200',
                    'responseMessage' => 'Status is already set to ' . $newStatus,
                    'responseType' => 'success'
                ], 200);
            }

            // Update question reactions based on existing record and new status
            if ($existingRecord) {
                if ($existingRecord->status == 0) {
                    if ($newStatus == 1) {
                        $question->upvote--;
                        $question->downvote++;
                        $message = "dislike + 1 , like - 1";
                    } elseif ($newStatus == 2) {
                        $question->upvote--;
                        $message = "like - 1 ";
                    }
                } elseif ($existingRecord->status == 1) {
                    if ($newStatus == 0) {
                        $question->upvote++;
                        $question->downvote--;
                        $message = "dislike - 1 , like + 1";
                    } elseif ($newStatus == 2) {
                        $question->downvote--;
                        $message = "dislike - 1 ";
                    }
                } elseif ($existingRecord->status == 2) {
                    if ($newStatus == 0) {
                        $question->upvote++;
                        $message = "like + 1";
                    } elseif ($newStatus == 1) {
                        $question->downvote++;
                        $message = "dislike + 1 ";
                    }
                }
                $existingRecord->update(['status' => $newStatus]);
            } else {
                // Create new reaction if no existing record found
                if ($newStatus == 0) {
                    $question->upvote++;
                    $message = "like + 1 ";
                } elseif ($newStatus == 1) {
                    $question->downvote++;
                    $message = "dislike - 1 ";
                }

                FourmQuestionReaction::create([
                    'question_id' => $questionId,
                    'user_id' => $userId,
                    'status' => $newStatus,
                ]);
            }

            // Save the changes to the question
            $question->save();

            DB::commit();

            return response()->json([
                'responseCode' => '200',
                'responseMessage' => 'Status updated successfully',
                'responseType' => 'success',
                'question' => $question,
                'action' => $message,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'responseCode' => '401',
                'responseMessage' => 'Internal Server Error: ' . $e->getMessage(),
                'responseType' => 'success',
            ], 200);
        }
    }


}
