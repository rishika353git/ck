<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class WalletController extends Controller
{
    public function wallet(){
        $userId = Auth::id();
        $wallet = Wallet::where("user_id", $userId)->first();
        $response = [
            'message' => 'User Wallet Get Successful',
            'status' => 'success',
            'amount' => $wallet->total_coins,
        ];

        return response()->json($response);

    }
    public function withdrawal(Request $request){
        $userId = Auth::id();

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => 'fail'], 400);
        }

        $amount = $request->amount;
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            return response()->json(['message' => 'Wallet not found', 'status' => 'fail'], 404);
        }

        if ($wallet->total_coins < 100) {
            return response()->json(['message' => 'Your Wallet Balance is Less than 500', 'status' => 'fail', 'amount' => $wallet->total_coins], 200);
        }

        if ($wallet->total_coins < $amount) {
            return response()->json(['message' => 'Insufficient Balance', 'status' => 'fail', 'amount' => $wallet->total_coins], 200);
        }

        if ($wallet->status == 0) {
            return response()->json(['message' => 'Deactivated Wallet', 'status' => 'fail'], 200);
        }

        $data = [
            'user_id' => $userId,
            'coins' => $amount,
        ];

        DB::beginTransaction();

        try {
            $withdrawalRequest = Withdrawal::create($data);
            DB::commit();

            return response()->json(['message' => 'Withdrawal Request Added Successfully', 'status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Internal Server Error', 'status' => 'fail', 'error_msg' => $e->getMessage()], 500);
        }
    }


}
