<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckInController extends Controller
{
    public function checkin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'court' => 'required',
            'sub_court' => 'required',
            'visit_time' => 'required',
            'expiry_time' => 'required',
            'reason_to_visit' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'responseCode' => '400',
                'responseMessage' => $validator->errors()->first(),
                'responseType' => 'fail'
            ], 200);
        } else {
            $currentTime = Carbon::now();
            $formattedTime = $currentTime->format('Y-m-d H:i:s');
            $userId = Auth::id();
            $checkIn = CheckIn::where('user_id', $userId)->latest('created_at')->first();

            if (empty($checkIn)) {
                $data = [
                    'user_id' => $userId,
                    'court' => $request->court,
                    'sub_court' => $request->sub_court,
                    'visit_time' => $request->visit_time,
                    'expiry_time' => $request->expiry_time,
                    'reason_to_visit' => $request->reason_to_visit,
                ];

                DB::beginTransaction();
                try {
                    $CheckIn = CheckIn::create($data);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    p($e->getMessage());
                    $CheckIn = null;
                }

                if ($CheckIn != null) {
                    return response()->json([
                        'responseCode' => '200',
                        'responseMessage' => 'Check-In Successfully',
                        'responseType' => 'success',
                    ], 200);
                } else {
                    return response()->json([
                        'responseCode' => '200',
                        'responseMessage' => 'Internal Serve error',
                        'responseType' => 'fail',
                    ], 500);
                }
            }

            $stored_expiry_time = $checkIn->expiry_time;

            if ($stored_expiry_time <= $formattedTime) {

                DB::beginTransaction();
                try {
                    $checkIn->status = 1;
                    $checkIn->save();
                    DB::commit();

                } catch (\Exception $err) {
                    DB::rollBack();
                    $checkIn = null;
                }

                $data = [
                    'user_id' => $userId,
                    'court' => $request->court,
                    'sub_court' => $request->sub_court,
                    'visit_time' => $request->visit_time,
                    'expiry_time' => $request->expiry_time,
                    'reason_to_visit' => $request->reason_to_visit,
                ];

                DB::beginTransaction();
                try {
                    $CheckIn = CheckIn::create($data);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    p($e->getMessage());
                    $CheckIn = null;
                }

                if ($CheckIn != null) {
                    return response()->json([
                        'responseCode' => '200',
                        'responseMessage' => 'Check-In Successfully',
                        'responseType' => 'success',
                    ], 200);
                } else {
                    return response()->json([
                        'responseCode' => '401',
                        'responseMessage' => 'Internal Serve error',
                        'responseType' => 'fail',
                    ], 200);
                }
            } else {
                return response()->json([
                    'responseCode' => '200',
                    'responseMessage' => 'You are already engaged',
                    'responseType' => 'success',
                ], 200);
            }

        }
    }

    public function history()
    {
        $userId = Auth::id();

        $checkIn = DB::table('checkin')
            ->join('court', 'checkin.court', '=', 'court.id')
            ->join('sub_court', 'checkin.sub_court', '=', 'sub_court.id')
            ->select(
                'court.name as court_name',
                'sub_court.name as sub_court_name',
                'checkin.visit_time',
                'checkin.expiry_time',
                'checkin.reason_to_visit',
                'checkin.status',
            )
            ->where('checkin.user_id', $userId)
            ->get();

        if ($checkIn->isNotEmpty()) {
            $response = [
                'responseCode' => '200',
                'responseMessage' => $checkIn->count() . ' entry found',
                'responseType' => 'success',
                'data' => $checkIn,
            ];
        } else {
            $response = [
                'responseCode' => '200',
                'responseMessage' => $checkIn->count() . ' entry found',
                'responseType' => 'fail',
                'data' => [],
            ];
        }

        return response()->json($response, 200);
    }


    public function update()
    {
        $userId = Auth::id();
        $checkIn = CheckIn::where('user_id', $userId)->latest('created_at')->first();

        $currentTime = Carbon::now();
        $formattedTime = $currentTime->format('Y-m-d H:i:s');

        // if ($checkIn->expiry_time <= $formattedTime) {
            if (empty($checkIn)) {
                return response()->json([
                    'responseCode' => '200',
                    'responseMessage' => 'Currently, you are free.',
                    'responseType' => 'success',
                ], 200);
            }

        DB::beginTransaction();
        try {
            $checkIn->expiry_time = $formattedTime;
            $checkIn->status = 1;
            $checkIn->save();
            DB::commit();

        } catch (\Exception $err) {
            DB::rollBack();
            $checkIn = null;
        }

        if (is_null($checkIn)) {
            return response()->json([
                'responseCode' => '200',
                'responseMessage' => $err->getMessage(),
                'responseType' => 'fail',

            ], 200);
        } else {
            return response()->json([
                'responseCode' => '200',
                'responseMessage' => 'Currently, you are free.',
                'responseType' => 'success',
            ], 200);
        }

    }
}
