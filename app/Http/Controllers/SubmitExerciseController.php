<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Auth;

class SubmitExerciseController extends Controller
{
    public function submit(Request $request)
    {
        // Validate request data
        $request->validate([
            'exerciseId' => 'required',
            'file' => 'required|file|mimes:pdf,docx|max:10240', // Max file size: 10MB
        ]);

        // Retrieve the Exercise instance
        $submit = SubmitExercise::find($request->exerciseId);

        // Check if the Exercise instance exists
        if ($submit) {
            // Save additional data to the Exercise instance
            $submit->user_id = Auth::user()->id;
            $submit->exercise_id = $request->exerciseId;
            $request->file = $request->file;
            // Save the Exercise instance
            $submit->save();

            // Return success response
            return response()->json([
                'status' => 200,
            ]);
        } else {
            // Return error response if Exercise instance not found
            return response()->json([
                'status' => 404,
                'message' => 'Exercise not found.',
            ], 404);
        }
    }
    
    // public function submit(Request $request)
    // {
    //     $request->validate([
    //         'exerciseId' => 'required',
    //         'file' => 'required|file|mimes:pdf,docx|max:10240',
    //     ]);

    //     $submit = Exercise::find($request->exerciseId);

    //     if ($submit) {
    //         $submit->user_id = Auth::user()->id;
    //         $submit->save();

    //         return response()->json([
    //             'status' => 200,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'Exercise not found.',
    //         ], 404);
    //     }
    // }

}
