<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\TransactionHistory;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $requests = DB::table('withdrawal')
            ->join('wallet', 'wallet.user_id', '=', 'withdrawal.user_id')
            ->join('users', 'users.id', '=', 'withdrawal.user_id')
            ->select(
                'withdrawal.*',
                'wallet.*',
                'users.*',
                'withdrawal.id as withdrawal_id',
                'wallet.id as wallet_id',
                'users.id as user_id'
            )
            ->orderBy('withdrawal.created_at', 'desc')
            ->get();

        return view('withdrawal.index', compact('requests'));

    }

    public function approve(Request $request)
    {
        $user_id = $request->user_id;
        $wallet_id = $request->wallet_id;
        $withdrawal_request_id = $request->withdrawal_request_id;

        $withdrawal_request = Withdrawal::where('id', $withdrawal_request_id)->first();

        if ($withdrawal_request) {
            $requestamount = $withdrawal_request->coins;

            DB::beginTransaction();

            try {
                $withdrawal_request->request_status = 1;
                $withdrawal_request->save();

                $wallet_history = Wallet::where('id', $wallet_id)->first();
                $previous_amount = $wallet_history->total_coins;
                $new_amount = $previous_amount - $requestamount;
                $wallet_history->total_coins = $new_amount;
                $wallet_history->save();

                $data = [
                    'user_id' => $user_id,
                    'type' => 0,
                    'transaction_id' => 'Approve by Admin',
                    'amount' => $new_amount,
                    'used_for' => 'Withdrawal',
                ];

                $TransactionHistory = TransactionHistory::create($data);

                DB::commit();

                return redirect()->route('withdrawal.request')->with('success', 'Withdrawal Request Approved Successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Internal Server Error: ' . $e->getMessage());
            }
        } else {
            return back()->with('error', 'Withdrawal Request not found');
        }
    }

}
