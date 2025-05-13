<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumOfflineEventPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForumOfflineEventPostController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'event_name' => 'required',
            'event_date_time' => 'required',
            'venue_address' => 'required',
            // 'event_link' => 'required',
            'description' => 'required',
            'speakers' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        } else {
            $userId = Auth::id();

            // Handle file upload
            if ($request->hasFile('image')) {
                $filename = time() . "_OnlineEvent." . $request->file('image')->getClientOriginalExtension();

                // Store file in public/uploads directory
                $request->file('image')->storeAs('uploads', $filename, 'public');
                $file_path = 'uploads/' . $filename; // Save path to the database
            } else {
                $file_path = null;
            }

            $data = [
                'user_id' => $userId,
                'event_name' => $request->event_name,
                'event_date_time' => $request->event_date_time,
                'venue_address' => $request->venue_address,
                'event_link' => $request->event_link,
                'description' => $request->description,
                'speakers' => $request->speakers,
                'image' => $file_path,
            ];

            DB::beginTransaction();
            try {
                $Post = ForumOfflineEventPost::create($data);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                echo $e->getMessage();
                $Post = null;
            }

            if ($Post != null) {
                return response()->json([
                    'message' => 'Offline Event added Successfully',
                    'status' => 'success',
                    'data'=> $Post
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
