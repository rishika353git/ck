<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'loginid' => 'required',
            'password' => 'required',
        ]);

         if ($validator->fails()) {
            return response()->json([
                'responseCode' => '400',
                'responseMessage' => $validator->errors()->first(),
                'responseType' => 'fail'
            ], 200);
        }

        $user = User::where('email', $request->loginid)->orWhere('mobile', $request->loginid)->first();

        if ($user && Hash::check($request->password, $user->password)) {

             Auth::login($user);
                $token = $user->createToken('auth-token')->plainTextToken;

            if ($user->mobile_verified == 0 ) {
                return response()->json([
                    'responseCode' => '200',
                    'verificationStatus' => '0',
                    'responseMessage' => 'Mobile Number Not Verified',
                    'responseType' => 'success',
                    'userrole' => $user->user_roll,
                    'token' => $token,
                    'data' => [],
                ], 200);
            }
            elseif($user->user_roll == 0 ){
                return response()->json([
                    'responseCode' => '200',
                    'verificationStatus' => '1',
                    'responseMessage' => 'User Role Not verifiedverified',
                    'responseType' => 'success',
                    'userrole' => $user->user_roll,
                    'token' => $token,
                    'data' => [],
                ], 200);
            }
            elseif($user->card_front == "" ){
                return response()->json([
                    'responseCode' => '200',
                    'verificationStatus' => '2',
                    'responseMessage' => 'Front identity Card Empty',
                    'responseType' => 'success',
                    'userrole' => $user->user_roll,
                    'token' => $token,
                    'data' => [],
                ], 200);
            }
             elseif( $user->card_back == ""){
                return response()->json([
                    'responseCode' => '200',
                    'verificationStatus' => '3',
                    'responseMessage' => 'Back identity Card Empty',
                    'responseType' => 'success',
                    'userrole' => $user->user_roll,
                    'token' => $token,
                    'data' => [],
                ], 200);
            }
            elseif($user->card_verified == 0){
                return response()->json([
                    'responseCode' => '200',
                    'verificationStatus' => '4',
                    'responseMessage' => 'User Pending',
                    'responseType' => 'success',
                    'userrole' => $user->user_roll,
                    'token' => $token,
                    'data' => [],
                ], 200);
            }
            elseif($user->card_verified == 2){
                $reason = $user->reason;
                return response()->json([
                    'responseCode' => '200',
                    'verificationStatus' => '5',
                    'responseMessage' => 'User Rejected By Admin',
                    'responseType' => 'success',
                    'userrole' => $user->user_roll,
                    'token' => $token,
                    'data' => [],

                ], 200);
            }elseif($user->card_verified == 3){
                return response()->json([
                    'responseCode' => '200',
                    'verificationStatus' => '6',
                    'responseMessage' => 'You’re Blocked',
                    'responseType' => 'success',
                    'userrole' => $user->user_roll,
                    'token' => $token,
                    'data' => [],


                ], 200);
            }
             else {


                $userData = [
                    'id' => $user->id,
                    'name' => $user->name ?? '',
                    'email' => $user->email ?? '',
                    'mobile' => $user->mobile ?? '',
                    'profile' => $user->profile ?? '',
                 ];
                return response()->json([
                    'responseCode' =>'200',
                    'verificationStatus' => '7',
                    'responseMessage' => 'Login Successful',
                    'responseType' => 'success',
                    'token' => $token,
                    'data' => $userData,
                ], 200);

            }

        } else {
            return response()->json([
                'responseCode' => '401',
                'verificationStatus' => '8',
                'responseMessage' => 'Login failed. Incorrect credentials.',
                'responseType' => 'fail',
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'responseCode' => '200',
            'responseMessage' => 'User Logout Successfully',
            'responseType' => 'success',
        ], 200);

    }
}
