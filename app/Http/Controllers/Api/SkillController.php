<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
    * @OA\Post(
    * path="/api/user/skill",
    * operationId="skill",
    * tags={"skill"},
    * summary="User skill",
    * description="User skill here",
    *     @OA\RequestBody(
    *         @OA\JsonContent(),
    *         @OA\MediaType(
    *            mediaType="multipart/form-data",
    *            @OA\Schema(
    *               type="object",
    *               required={"name","email","mobile", "password", "password_confirmation"},
    *               @OA\Property(property="name", type="text", example="shiva"),
    *               @OA\Property(property="email", type="text", example="shiva9291@gmail.com"),
    *               @OA\Property(property="mobile", type="number", example="9876543210"),
    *               @OA\Property(property="password", type="password", example="09876543210"),
    *               @OA\Property(property="password_confirmation", type="password", example="09876543210")
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

    public function index(Request $request)
  
    {
        try {
            // Get the search input or set it to an empty string if not provided
            $search = $request->input('search', '');

            // Validate the search input if necessary (e.g., max length, allowed characters)

            // Search for Courts, selecting only id and name
            $Skill = Skill::select('id', 'name')
                           ->where('name', 'LIKE', "%$search%")
                           ->where('status',1);


            $perPage = $request->perpage??15; // Number of items per page
            $paginatedData = $Skill->paginate($perPage);


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
