<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\SubCourt;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            // Get the search input or set it to an empty string if not provided
            $search = $request->input('search', '');

            // Validate the search input if necessary (e.g., max length, allowed characters)

            // Search for Courts, selecting only id and name
            $courts = Court::select('id', 'name')
                           ->where('name', 'LIKE', "%$search%")
                           ->get();

            // Search for SubCourts, selecting only id and name
            $subCourts = SubCourt::select('id','name')
                                 ->where('name', 'LIKE', "%$search%")
                                 ->get();

            // Prepare the response
            $response = [
                'responseCode' => '200',
                'responseMessage' => count($courts) . ' Court(s) found & ' . count($subCourts) . ' SubCourt(s) found',
                'responseType' => 'success',
                'courts' => $courts,
                'subCourts' => $subCourts,
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json([
                'responseCode' => 401,
                'responseMessage' => 'An error occurred: ' . $e->getMessage(),
                'responseType' => 'error'
            ], 200);
        }
    }

}
