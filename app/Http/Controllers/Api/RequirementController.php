<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RequirementController extends Controller
{

    public function index()
    {}
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        } else {
            $userId = Auth::id();
            $data = [
                'user_id' => $userId,
                'job_id' => $request->job_id,
            ];
            DB::beginTransaction();
            try {
                $Requirement = Requirement::create($data);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                echo $e->getMessage();
                $Requirement = null;
            }

            if ($Requirement != null) {
                return response()->json([
                    'message' => 'Job Apply Successfully',
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

    public function applyhistory()
    {
        $userId = Auth::id();

        $data = DB::table('requirement_listing')
            ->join('forum_hiring_post', 'requirement_listing.job_id', 'forum_hiring_post.id')
            ->select('requirement_listing.*', 'forum_hiring_post.*')
            ->where('requirement_listing.user_id',$userId)
            ->get();

        if (count($data) > 0) {
            $response = [
                'message' => count($data) . ' Applyed job found',
                'status' => 'success',
                'data' => $data,
            ];
        } else {
            $response = [
                'message' => count($data) . ' users found',
                'status' => 'fail',

            ];
        }
        return response()->json($response, 200);

    }

}
