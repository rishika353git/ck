<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AreaPractice;

class areaOfPractiseController extends Controller
{
    public function index(Request $request)
  
    {
        try {
            // Get the search input or set it to an empty string if not provided
            $search = $request->input('search', '');

            // Validate the search input if necessary (e.g., max length, allowed characters)

            // Search for Courts, selecting only id and name
            $AreaPractice = AreaPractice::select('id', 'name')
                           ->where('name', 'LIKE', "%$search%")
                           ->where('status',1);


            $perPage = $request->perpage??15; // Number of items per page
            $paginatedData = $AreaPractice->paginate($perPage);


            // Prepare the response
            $response = [
                'responseCode' => '200',
                
                'responseType' => 'success',
                'data' => $paginatedData->items(),
                'pagination' => [
                    'total' => $paginatedData->total(),
                    'per_page' => $paginatedData->perPage(),
                    'current_page' => $paginatedData->currentPage(),
                    'last_page' => $paginatedData->lastPage(),
                ],
            ];

            return response()->json($response, 200);

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
