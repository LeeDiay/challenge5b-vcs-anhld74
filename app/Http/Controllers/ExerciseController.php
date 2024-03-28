<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use Illuminate\Auth\AuthManager;
class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::paginate(5); 
        return view('exercises.exercises-management', ['exercises' => $exercises]);
    }

    public function show($id)
    {
        $exercise = Exercise::findOrFail($id);

        return view('exercise.detail', compact('exercise'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'duration' => 'required|date',
            'file' => 'sometimes|mimes:pdf,docx', 
        ]);
        $fileName = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = uniqid('file_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/upload/'), $fileName);
        } 

        $exerciseData = [
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'file' => $fileName,
        ];

        $exercise = Exercise::create($exerciseData);

        if ($exercise) {
            // thêm thành công
            return response()->json([
                'status' => 200,
            ]);
        } else {
            // lỗi
            return response()->json([
                'status' => 500,
            ]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'duration' => 'required|date',
            'file' => 'sometimes|mimes:pdf,docx',
        ]);

        $exercise = Exercise::find($request->exerciseId);
        if (!$exercise) {
            return response()->json([
                'status' => 500,
                'message' => 'Không tìm thấy bài tập.',
            ]);
        }

        $oldFileName = $exercise->file; 

        $fileName = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = uniqid('file_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('files/upload/'), $fileName);           
            unlink(public_path('files/upload/' . $oldFileName));
        }

        $exerciseData = [
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'file' => $fileName,
        ];

        $exercise->update($exerciseData);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'exerciseId' => 'required',
        ]);
    
        $exercise = Exercise::find($request->exerciseId);
    
        if ($exercise) {
            if ($exercise->file) {
                $filePath = public_path('files/upload/' . $exercise->file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
    
            $exercise->delete();
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Không tìm thấy bài tập.',
            ]);
        }
    }

    public function getTotalExercisesCount()
    {
        $totalExercisesCount = Exercise::count();

        return response()->json(['total_exercises_count' => $totalExercisesCount]);
    }
}
