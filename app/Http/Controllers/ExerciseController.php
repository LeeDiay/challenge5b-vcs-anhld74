<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Auth;

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
            'name' => 'required|string|regex:/^[a-zA-Z0-9_\sàáảãạăắằẳẵặâấầẩẫậèéẻẽẹêếềểễệđìíỉĩịòóỏõọôốồổỗộơớờởỡợùúủũụưứừửữựỳỹỷỵÀÁẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬÈÉẺẼẸÊẾỀỂỄỆĐÌÍỈĨỊÒÓỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÙÚỦŨỤƯỨỪỬỮỰỲỸỶỴ\s]+$/u',
            'description' => 'string',
            'duration' => 'required|date',
            'file' => 'sometimes|mimes:pdf,docx', 
        ]);
        $fileName = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName(); // Lấy tên gốc của tệp tin
            $extension = $file->getClientOriginalExtension(); // Lấy phần mở rộng của tệp tin
            $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension; // Tên và phần mở rộng gốc
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
            return response()->json([
                'status' => 500,
            ]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z0-9_\sàáảãạăắằẳẵặâấầẩẫậèéẻẽẹêếềểễệđìíỉĩịòóỏõọôốồổỗộơớờởỡợùúủũụưứừửữựỳỹỷỵÀÁẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬÈÉẺẼẸÊẾỀỂỄỆĐÌÍỈĨỊÒÓỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÙÚỦŨỤƯỨỪỬỮỰỲỸỶỴ\s]+$/u',
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

        $fileName = $exercise->file;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName(); // Lấy tên gốc của tệp tin
            $extension = $file->getClientOriginalExtension(); // Lấy phần mở rộng của tệp tin
            $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension; // Tên và phần mở rộng gốc
            $file->move(public_path('files/upload/'), $fileName);
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

    public function submit(Request $request)
    {
        // Validate request data
        $request->validate([
            'exerciseId' => 'required',
            'file' => 'required|file|mimes:pdf,docx|max:10240', // Max file size: 10MB
        ]);

        // Retrieve the Exercise instance
        $submit = Exercise::find($request->exerciseId);

        // Check if the Exercise instance exists
        if ($submit) {
            // Save additional data to the Exercise instance
            $submit->user_id = Auth::user()->id;
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

    public function getTotalExercisesCount()
    {
        $totalExercisesCount = Exercise::count();

        return response()->json(['total_exercises_count' => $totalExercisesCount]);
    }
}
