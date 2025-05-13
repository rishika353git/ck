<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Retrieve the user's wallet, ensuring to handle the case where the wallet might not exist
        $wallet = Wallet::where('user_id', $userId)->first();

        // Retrieve posts with user information
        $posts = DB::table('forum_normal_post')
            ->join('users', 'forum_normal_post.user_id', '=', 'users.id')
            ->select('users.name', 'users.profile', 'forum_normal_post.created_at',
                     'forum_normal_post.description', 'forum_normal_post.files',
                     'forum_normal_post.upvote', 'forum_normal_post.downvote',
                     'forum_normal_post.share', 'forum_normal_post.repost')
            ->get();
        $emptywallet = 0.0;
        // Prepare the data to be returned
        $data = [
           // 'wallet_balance' => $wallet ? $wallet->total_coins : $emptywallet, // Handle case where wallet is null
            'wallet_balance' =>  $wallet->total_coins,
            'posts' => $posts,
        ];

        // Prepare the response
        $response = [
            'responseCode' => '200',
            'responseMessage' => 'User Data Get succesfully ',
            'responseType' => 'success',
            'responsedata' => $data,
        ];

        // Return the response as JSON
        return response()->json($response);
    }

}
