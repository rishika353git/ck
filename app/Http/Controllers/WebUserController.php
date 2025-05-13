<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Court;
use App\Models\Profile;
use App\Models\TransactionHistory;
use App\Models\SubCourt;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(8);
        $usersCount = User::count();
        $courtCount = Court::count();
        $courts = Court::orderBy('created_at', 'desc')->paginate(5);
        $subCourtCount = SubCourt::count();
        $inactiveUsersCount = User::where('card_verified', 0)->count();
        $activeUsersCount = User::where('card_verified', 1)->count();
        $rejectUsersCount = User::where('card_verified', 2)->count();
        $blockedUserCount = User::where('card_verified', 3)->count();

        return view("home", compact('users', 'usersCount', 'inactiveUsersCount', 'activeUsersCount', 'rejectUsersCount','courts','subCourtCount','courtCount','blockedUserCount'));


    }

    public function users(){
        $users = User::get();
        return view('user.alluser', compact('users'));
    }
    public function ActiveUser()
    {
        $users = User::where('card_verified', 1)->get();
        return view('user.activeuser', compact('users'));
    }

    public function PendingUser()
    {
        $users = User::where('card_verified', 0)->get();
        return view('user.pendinguser', compact('users'));
    }

    public function RejectUser()
    {
        $users = User::where('card_verified', 2)->get();
        return view('user.rejectuser', compact('users'));
    }

    public function blockedUser(){
        $users = User::where('card_verified', 3)->get();
        return view('user.blockeduser', compact('users'));
    }
    public function PendingUserUpdate(Request $request)
    {
        $userId = $request->user_id;
        $status = $request->status;
        $reason = $request->reason;

        $finduser = User::where('id', $userId)->first();
        if ($finduser) {

            if ($status == 1) {
                $finduser->card_verified = $status;
                $action = $finduser->save();
                if ($action) {
                    return redirect()->route('activeuser')->with('success', 'User Status Update Successfully');
                } else {
                    return back()->with('error', 'Internal Serve Error');
                }
            } elseif ($status == 2) {
                $finduser->card_verified = $status;
                $finduser->reason = $reason;
                $action = $finduser->save();
                if ($action) {
                    return redirect()->route('rejectuser')->with('success', 'User Status Update Successfully');
                } else {
                    return back()->with('error', 'Internal Serve Error');
                }
            } elseif($status == 3) {
                $finduser->card_verified = $status;
                $action = $finduser->save();
                if ($action) {
                    return redirect()->route('all.users')->with('success', 'User Status Update Successfully');
                } else {
                    return back()->with('error', 'Internal Serve Error');
                }
            }

        } else {
            return back()->with('error', 'User Not Found');
        }

    }

    public function profile($id){
      $data = DB::table('users')
            ->join('profile', 'users.id', 'profile.user_id')
            ->select('users.*',
                'profile.*',
                'users.id as user_id',)
                ->where('users.id' ,$id)
            ->first();
      $transactions = TransactionHistory::where('user_id',$id)->orderBy('created_at','desc')->get();
      $wallet = Wallet::where('user_id',$id)->first();
      return view('user.profile',compact('data','transactions','wallet'));
    }

    public function deleteUser($id){
        $User = User::findOrFail($id);
        $profiledata = Profile::where('user_id',$id)->first();
        $User->delete();
        $profiledata->delete();


        if($User){
            return redirect()->route('all.users')->with('delete', 'User Delete Successfully');
        }else{
            return redirect()->route('all.users')->with('info', 'Internal Serve Error');
        }
    }
}
