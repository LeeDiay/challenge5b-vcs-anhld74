<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\SubmitExercise;
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
        $request->validate([
            'exerciseId' => 'required',
            'file' => 'required|file|mimes:pdf,docx|max:10240',
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName(); 
            $extension = $file->getClientOriginalExtension(); 
            $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension; 
            $file->move(public_path('files/submit/'), $fileName);
        }

        $submit = new SubmitExercise();
        $submit->user_id = Auth::user()->id;
        $submit->exercise_id = $request->exerciseId;
        $submit->file = $fileName;
        $submit->save();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function getSubmittedExercises($exerciseId)
{
    // Lấy danh sách các bài tập đã nộp cho bài tập được chỉ định
    $submittedExercises = SubmitExercise::where('exercise_id', $exerciseId)
                                        ->whereNotNull('file') // Chỉ lấy các bài đã nộp
                                        ->with('user')
                                        ->get();

    return response()->json([
        'status' => 200,
        'submittedExercises' => $submittedExercises,
    ]);
}

    public function getTotalExercisesCount()
    {
        $totalExercisesCount = Exercise::count();

        return response()->json(['total_exercises_count' => $totalExercisesCount]);
    }
}
