<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Premium;

class PremiumController extends Controller
{
    public function index(){
        $Premium = Premium::where("status",1)->orderBy("created_at","desc")->get();
        if (count($Premium) > 0) {
            $response = [
                'message' => count($Premium) . ' Plans found',
                'status' => 'success',
                'data' => $Premium,
            ];
        } else {
            $response = [
                'message' => count($Premium) . ' Plans found',
                'status' => 'fail',

            ];
        }
        return response()->json($response, 200);
    }
}
