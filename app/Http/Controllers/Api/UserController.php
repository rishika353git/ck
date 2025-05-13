<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/** @OA\Info(
    *    title="Councel Connect",
    *    version="1.0.0",
    * )
    */
class UserController extends Controller
{
    public function index()
    {
        $users = User::select('name', 'email', 'mobile')->get();
        if (count($users) > 0) {
            $response = [
                'responseMessage' => count($users) . ' users found',
                'responseType' => 'success',
                'responseData' => $users,
            ];
        } else {
            $response = [
                'responseMessage' => count($users) . ' users found',
                'responseType' => 'fail',

            ];
        }
        return response()->json($response, 200);
    }

    function generateOTP()
    {
        $otp = rand(1000, 9999);
        return $otp;
    }

/**
 * @OA\Post(
 * path="/api/user/register",
 * operationId="Register",
 * tags={"Register"},
 * summary="User Register",
 * description="User Register here",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *            mediaType="multipart/form-data",
 *            @OA\Schema(
 *               type="object",
 *               required={"name", "email", "mobile", "password", "password_confirmation", "_token"},
 *               @OA\Property(property="name", type="string", example="shiva"),
 *               @OA\Property(property="email", type="string", example="shiva9291@gmail.com"),
 *               @OA\Property(property="mobile", type="string", example="9876543210"),
 *               @OA\Property(property="password", type="string", format="password", example="09876543210"),
 *               @OA\Property(property="password_confirmation", type="string", format="password", example="09876543210"),
 *               @OA\Property(property="_token", type="string", example="csrf_token_here", description="CSRF token. Include this as a hidden field in the form or as a header.")
 *            ),
 *        ),
 *    ),
 *      @OA\Response(
 *          response=201,
 *          description="Register Successfully",
 *          @OA\JsonContent()
 *       ),
 *      @OA\Response(
 *          response=200,
 *          description="Register Successfully",
 *          @OA\JsonContent()
 *       ),
 *      @OA\Response(
 *          response=422,
 *          description="Unprocessable Entity",
 *          @OA\JsonContent()
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 * )
 */




    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => ['required', 'min:10', 'unique:users,mobile', 'regex:/^[1-9]\d{9}$/'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'responseCode' => '400',
                'responseMessage' => $validator->errors()->first(),
                'responseType' => 'fail'],
                200);
        } else {
           // dd($request->all());
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ];
            DB::beginTransaction();
            try {
                $user = User::create($data);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
               return response()->json([
                'responseCode' => '200',
                'responseMessage' => $e->getMessage(),
                'responseType' => 'fail',
            ], 200);
            }
            if ($user != null) {
                $generatedOTP = $this->generateOTP();
                $otpdata = [
                    'mobile' => $request->mobile,
                    'otp' => $generatedOTP,
                    'generatetime' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
                ];
                DB::beginTransaction();
                try {
                    $otp = Otp::create($otpdata);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'responseCode' => '200',
                        'responseMessage' => $e->getMessage(),
                        'responseType'=>'fail',
                    ], 200);
                }

                if ($otp != null) {
                    $profiledata = [
                        'user_id' => $user->id,
                        'previous_experiences' => "[]",
                        'home_courts' => "[]",
                        'area_of_practice' => "[]",
                        'top_5_skills' => "[]",
                    ];

                    DB::beginTransaction();
                    try {
                        $profile = Profile::create($profiledata);
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return response()->json([
                            'responseCode' => '200',
                            'responseMessage' => $e->getMessage(),
                            'responseType' => 'fail',
                        ], 200);
                    }
                }

                if ($otp != null) {
                    $Wallet = [
                        'user_id' => $user->id,
                        'total_coins' => "[]",
                    ];

                    DB::beginTransaction();
                    try {
                        $Wallet = Wallet::create($Wallet);
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return response()->json([
                            'responseCode' => '200',
                            'responseMessage' => $e->getMessage(),
                            'responseType' => 'fail',
                        ], 200);
                    }
                }

                return response()->json([
                    'responseCode' => '200',
                    'responseMessage' => 'OTP Sent Successfully',
                    'responseType' => 'success',
                    'otp' => $generatedOTP,
                    'mobile' => $request->mobile,
                ], 200);
            } else {
                return response()->json([
                    'responseCode' => '200',
                    'responseMessage' => 'Internal Serve error',
                    'responseType' => 'fail',
                ], 500);
            }

        }
    }


    public function verification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'min:10', 'regex:/^[1-9]\d{9}$/'],
            'otp' => ['required', 'min:4', 'max:4'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'responseCode' => '200',
                'responseMessage' => $validator->errors()->first(),
                'responseType' => 'fail'],
                200);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json(['responseCode' => '200','responseMessage' => 'User not found', 'responseType' => 'fail'], 200);
        }

        $otp = Otp::where('mobile', $request->mobile)->where('otp', $request->otp)->where('generatetime','>',now())->orderBy('id','desc')->first();
        if (!$otp) {
            return response()->json(['responseCode' => '200','responseMessage' => 'Invalid otp', 'responseType' => 'fail'], 200);
        }

        $token = $user->createToken('auth-token')->plainTextToken;
        DB::beginTransaction();

        try {
        	if($user->mobile_verified != 1){
            $user->mobile_verified_at = Carbon::now(); //return current date and time
            $user->mobile_verified = 1;
        	}
            $user->remember_token = $token;
            $user->save();
            $otp->delete();
            // Wallet creation

            DB::commit();
            return response()->json([
                'responseCode' => '200',
                'responseMessage' => 'User Verified Successfully',
                'responseType' => 'success',
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'responseCode' => '200',
                'responseMessage' => 'Internal Server Error',
                'responseType' => 'fail',
                'error_msg' => $e->getMessage()], 200);
        }
    }




    public function resendotp(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'min:10', 'regex:/^[1-9]\d{9}$/'],
        ]);

        // Return validation errors, if any
        if ($validator->fails()) {
            return response()->json([
                'responseCode' => '200',
                'responseMessage' => $validator->messages()->first(),
                'responseType' => 'fail'
            ], 200);
        }

        // Check if the mobile number is registered
        $otpRecord = Otp::where('mobile', $request->mobile)->first();
        $currentTime = time();

        if (is_null($otpRecord)) {
            return response()->json([
                'responseCode' => '200',
                'responseMessage' => 'Please enter the registered mobile number.',
                'responseType' => 'error',
            ], 200);
        }

        $generate_otp_time = strtotime($otpRecord->generatetime); //is used to convert a human readable date string into a Unix timestamp (the number of seconds since January 1 1970 00:00:00 GMT).

        // Check if the OTP was generated recently
        // if ($currentTime - $generate_otp_time < 95) {
        //     return response()->json([
        //         'responseCode' => '200',
        //         'responseMessage' => 'Please try after some time.',
        //         'responseType' => 'error',
        //     ], 200);
        // }

        // Generate a new OTP and update the record
        DB::beginTransaction();
        try {
            $generatedOTP = $this->generateOTP();
            $otpRecord->otp = $generatedOTP;
            $otpRecord->generatetime = date('Y-m-d H:i:s', $currentTime + 10 * 60);
            $otpRecord->save();
            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());

            return response()->json([
                'responseCode' => '200',
                'responseMessage' => 'Internal Server Error',
                'responseType' => 'fail',
                'error_msg' => $err->getMessage(),
            ], 500);
        }

        return response()->json([
            'responseCode' => '200',
            'responseMessage' => 'OTP Sent Successfully',
            'responseType' => 'success',
            'otp' => $generatedOTP,
            'mobile' => $request->mobile,
        ], 200);
    }

    public function currentuserdetails(Request $request) {
        $userId = Auth::id();
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'responseCode' => '404',
                'responseMessage' => 'User not found',
                'responseType' => 'error',
                'responseData' => null,
            ], 404);
        }

        return response()->json([
            'responseCode' => '200',
            'responseMessage' => 'User data',
            'responseType' => 'success',
            'responseData' => $user,
        ], 200);
    }




}
