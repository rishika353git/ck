<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Poll;

class PollController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'ask_a_question' => 'required|string|max:255',
                'choice1' => 'required|string|max:255',
                'choice2' => 'required|string|max:255',
                'choice3' => 'nullable|string|max:255',
                'choice4' => 'nullable|string|max:255',
                'poll_duration' => 'required|integer|in:1,7' // 1 for day, 7 for week
            ]);

            // Convert poll_duration to seconds based on the allowed values
            $poll_duration_seconds = ($validatedData['poll_duration'] === 7) ? 7 * 24 * 60 * 60 : 24 * 60 * 60;

            // Add the converted duration to the data
            $validatedData['poll_duration'] = $poll_duration_seconds;

            // Create a new poll
            $poll = Poll::create($validatedData);

            $response = [
                'responseCode' => '200',
                'responseType' => 'success',
                'data' => $poll,
            ];

            return response()->json($response, 201);

        } catch (\Exception $e) {
            return response()->json([
                'responseCode' => '500',
                'responseMessage' => 'Failed to create poll: ' . $e->getMessage(),
                'responseType' => 'error',
                'data' => '',
            ], 500); 
        }
    }
}
