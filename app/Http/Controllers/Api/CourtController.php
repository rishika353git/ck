<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\SubCourt;
use App\Models\CheckIn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class CourtController extends Controller
{
    public function court(Request $request)
    {
        try {
            // Get the search input or set it to an empty string if not provided
            $search = $request->input('search', '');

            // Validate the search input if necessary (e.g., max length, allowed characters)

            // Search for Courts, selecting only id and name
            $courts = Court::select('id', 'name')
                           ->where('name', 'LIKE', "%$search%")
                           ->where('status',1);


            $perPage = $request->perpage??15; // Number of items per page
            $paginatedData = $courts->paginate($perPage);


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

    public function subcourt(Request $request)
        {
            $id = $request->query('id');
            if (is_null($id)) {
                return response()->json([
                    'responseCode' => '400',
                    'responseMessage' => 'Court ID is required',
                    'responseType' => 'fail'
                ], 200);
            }

            $subCourts = SubCourt::select('id', 'name')
                                ->where('court_id', $id)

                                ->get();
                                $subCourtsCount = count($subCourts);
           // dd($courtCount);
            if ($subCourts->isNotEmpty()) {
            $data = [];
            foreach ($subCourts as $subCourt) {
                $data[] = [
                    'id' => $subCourt->id,
                    'name' => $subCourt->name,
                ];
            }
                $response = [
                    'responseCode' => '200',
                    'responseMessage' => $subCourtsCount . ' Sub Courts found',
                    'responseType' => 'success',
                    'data' => $data,
                ];
            } else {
                $response = [
                'responseCode' => '200',
                'responseMessage' => 'No Sub Courts found',
                'responseType' => 'success',
                'data' => [],
                ];
            }

            return response()->json($response, 200);
        }

    public function availableUser(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'court_id' => 'required',
                'subcourt_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'responseCode' => '401',
                    'responseMessage' => $validator->errors()->first(),
                    'responseType' => 'fail'],
                    200);
            }else{
                $court_id = $request->court_id;
                $subcourt_id = $request->subcourt_id;
                $time = Carbon::now()->format('Y-m-d H:i:s');
                $currentTime = Carbon::now();

                $currentTime->addWeek(); // Add one week to the current time
                $oneWeekLater = $currentTime->format('Y-m-d H:i:s');

                $data = CheckIn::where('court', $court_id)
                               ->where('sub_court', $subcourt_id)
                               ->where('visit_time', '>' , $time )
                               ->where('expiry_time', '<', $oneWeekLater )
                               ->get();

                if (count($data) > 0) {
                    $response = [
                        'responseCode' => '200',
                        'responseMessage' => count($data) . ' User found',
                        'responseType' => 'success',
                        'currentime' => $currentTime->format('Y-m-d H:i:s'),
                        'data' => $data,
                    ];
                } else {
                    $response = [
                        'responseCode' => '200',
                        'responseMessage' => count($data) . ' User found',
                        'responseType' => 'success',
                        'currentime' => $currentTime->format('Y-m-d H:i:s'),
                        'data' => $data,

                    ];
                }
                return response()->json($response, 200);
            }
        }

}
