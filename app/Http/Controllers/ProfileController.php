<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $userId = Auth::id();
        $Profile = Profile::where('user_id', $userId)->first();
        return response()->json([
            'message' => 'Profile get Successfully.',
            'status' => 'success',
            'data' => $Profile,
        ], 200);
    }

    public function update(Request $request)
    {

        $userId = Auth::id();
        $profile = Profile::where('user_id', $userId)->first();

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found for the current user.',
                'status' => 'fail',
            ], 404);
        }

        DB::beginTransaction();
        try {
            $profile->year_of_enrollment = $request->year_of_enrollment ?? "0";
            $profile->current_designation = $request->current_designation ?? "";
            $profile->previous_experiences = $request->previous_experiences ?? [];
            $profile->home_courts = $request->home_courts ?? [];
            $profile->area_of_practice = $request->area_of_practice ?? [];
            $profile->law_school = $request->law_school ?? "";
            $profile->batch = $request->batch ?? "";
            $profile->linkedin_profile = $request->linkedin_profile ?? "";
            $profile->description = $request->description ?? "";
            $profile->profile_tagline = $request->profile_tagline ?? "";
            $profile->top_5_skills = $request->top_5_skills ?? [];
            $profile->total_follow = $request->total_follow ?? false;
            $profile->total_followers = $request->total_followers ?? 0;
            $profile->questions_asked = $request->questions_asked ?? 0;
            $profile->answers_given = $request->answers_given ?? 0;
            $profile->save();
            DB::commit();
            return response()->json([
                'message' => 'Profile updated successfully.',
                'status' => 'success',
                'data'=> $profile,
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'message' => 'Internal Server Error',
                'status' => 'fail',
                'error_msg' => $err->getMessage(),
            ], 500);
        }
    }

    public function userRoll(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'roll' => 'required',
        ]);

        // Return validation errors, if any
        if ($validator->fails()) {
            return response()->json([
                'responseCode' => '200',
                'responseMessage' => $validator->errors()->first(),
                'responseType' => 'fail'
            ], 200);
        }

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Prepare the data for update
        $data = [
            'roll' => $request->roll,
        ];

        // Begin a database transaction
        DB::beginTransaction();
        try {
            // Find the user by their ID
            $user = User::find($userId);

            // Update the user's roll if user is found
            if ($user) {
                $user->user_roll = $data['roll'];
                $user->save();
                DB::commit();

                return response()->json([
                    'responseCode' => '200',
                    'responseMessage' => 'User Roll Update Successfully',
                    'responseType' => 'success',
                ], 200);
            } else {
                throw new \Exception('User not found');
            }
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            // Log the error message
            Log::error($e->getMessage());

            return response()->json([
                'responseCode' => '500',
                'responseMessage' => 'Internal Server Error: ' . $e->getMessage(),
                'responseType' => 'fail',
            ], 500);
        }
    }


    public function uploadProfileImage(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Return validation errors, if any
        if ($validator->fails()) {
            return response()->json([
                'statuscode' => '400',
                'message' => $validator->errors()->first(),
                'status' => 'fail'
            ], 200);
        }

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Handle the front image
        if ($request->hasFile('profile')) {
            $profileFilename = time() . "_profile." . $request->file('profile')->getClientOriginalExtension();
            $request->file('profile')->storeAs('uploads', $profileFilename, 'public');
            $profile = 'uploads/' . $profileFilename; // Save path to the database
        } else {
            $profile = null;
        }

        // Prepare the data for update
        $data = [
            'profile' => $profile,
        ];

        // Begin a database transaction
        DB::beginTransaction();
        try {
            // Find the user by their ID
            $user = User::find($userId);

            // Update the user's card images if the user is found
            if ($user) {
                $user->profile = $data['profile'];
                $user->save();

                DB::commit();

                return response()->json([
                    'statuscode' => '200',
                    'message' => 'profile updated successfully',
                    'status' => 'success',
                ], 200);
            } else {
                throw new \Exception('User not found');
            }
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            // Log the error message
            Log::error($e->getMessage());

            return response()->json([
                'responseCode' => '200',
                'message' => 'Internal Server Error: ' . $e->getMessage(),
                'status' => 'fail',
            ], 200);
        }
    }

    public function uploadCardImage(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'front' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'back' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Return validation errors, if any
        if ($validator->fails()) {
            return response()->json([
                'responseCode' => '400',
                'responseMessage' => $validator->errors()->first(),
                '12' => 'fail'
            ], 200);
        }

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Handle the front image
        if ($request->hasFile('front')) {
            $frontFilename = time() . "_front." . $request->file('front')->getClientOriginalExtension();
            $request->file('front')->storeAs('uploads', $frontFilename, 'public');
            $front = 'uploads/' . $frontFilename; // Save path to the database
        } else {
            $front = null;
        }

        // Handle the back image
        if ($request->hasFile('back')) {
            $backFilename = time() . "_back." . $request->file('back')->getClientOriginalExtension();
            $request->file('back')->storeAs('uploads', $backFilename, 'public');
            $back = 'uploads/' . $backFilename; // Save path to the database
        } else {
            $back = null;
        }

        // Prepare the data for update
        $data = [
            'card_front' => $front,
            'card_back' => $back,
        ];

        // Begin a database transaction
        DB::beginTransaction();
        try {
            // Find the user by their ID
            $user = User::find($userId);

            // Update the user's card images if the user is found
            if ($user) {
                $user->card_front = $data['card_front'];
                $user->card_back = $data['card_back'];
                $user->save();

                DB::commit();

                return response()->json([
                    'responseCode' => '200',
                    'responseMessage' => 'Images updated successfully',
                    'responseType' => 'success',
                ], 200);
            } else {
                throw new \Exception('User not found');
            }
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            // Log the error message
            Log::error($e->getMessage());

            return response()->json([
                'responseCode' => '200',
                'responseMessage' => 'Internal Server Error: ' . $e->getMessage(),
                'responseType' => 'fail',
            ], 200);
        }
    }

}
