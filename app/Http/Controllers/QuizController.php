<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quizs = Quiz::paginate(5); 
        return view('quiz.quiz-management', ['quizs' => $quizs]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z0-9_\sàáảãạăắằẳẵặâấầẩẫậèéẻẽẹêếềểễệđìíỉĩịòóỏõọôốồổỗộơớờởỡợùúủũụưứừửữựỳỹỷỵÀÁẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬÈÉẺẼẸÊẾỀỂỄỆĐÌÍỈĨỊÒÓỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÙÚỦŨỤƯỨỪỬỮỰỲỸỶỴ\s]+$/u',
            'description' => 'string',
            'file' => 'sometimes|mimes:txt', 
        ]);
        $fileName = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName(); // Lấy tên gốc của tệp tin
            $extension = $file->getClientOriginalExtension(); // Lấy phần mở rộng của tệp tin
            $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension; // Tên và phần mở rộng gốc
            $file->move(public_path('files/quiz/'), $fileName);
        }
        
        $exerciseData = [
            'name' => $request->name,
            'description' => $request->description,
            'file' => $fileName,
        ];

        $quiz = Quiz::create($exerciseData);

        if ($quiz) {
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
            'description' => 'string|regex:/^[a-zA-Z0-9_\sàáảãạăắằẳẵặâấầẩẫậèéẻẽẹêếềểễệđìíỉĩịòóỏõọôốồổỗộơớờởỡợùúủũụưứừửữựỳỹỷỵÀÁẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬÈÉẺẼẸÊẾỀỂỄỆĐÌÍỈĨỊÒÓỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÙÚỦŨỤƯỨỪỬỮỰỲỸỶỴ\s]+$/u',
            'file' => 'sometimes|mimes:txt',
        ]);

        $quiz = Quiz::find($request->quizId);
        if (!$quiz) {
            return response()->json([
                'status' => 500,
                'message' => 'Không tìm thấy câu đố.',
            ]);
        }

        $oldFileName = $quiz->file; 

        $fileName = $quiz->file;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName(); // Lấy tên gốc của tệp tin
            $extension = $file->getClientOriginalExtension(); // Lấy phần mở rộng của tệp tin
            $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension; // Tên và phần mở rộng gốc
            $file->move(public_path('files/quiz/'), $fileName);
        }

        $quizData = [
            'name' => $request->name,
            'description' => $request->description,
            'file' => $fileName,
        ];

        $quiz->update($quizData);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'quizId' => 'required',
        ]);
    
        $quiz= Quiz::find($request->quizId);
    
        if ($quiz) {
            if ($quiz->file) {
                $filePath = public_path('files/quiz/' . $quiz->file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
    
            $quiz->delete();
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Không tìm thấy câu đố.',
            ]);
        }
    }
    public function submit(Request $request)
    {
        $request->validate([
            'quizId' => 'required|exists:quizzes,id',
            'answer' => 'required|string|regex:/^[a-zA-Z0-9_\sàáảãạăắằẳẵặâấầẩẫậèéẻẽẹêếềểễệđìíỉĩịòóỏõọôốồổỗộơớờởỡợùúủũụưứừửữựỳỹỷỵÀÁẢÃẠĂẮẰẲẴẶÂẤẦẨẪẬÈÉẺẼẸÊẾỀỂỄỆĐÌÍỈĨỊÒÓỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÙÚỦŨỤƯỨỪỬỮỰỲỸỶỴ\s]+$/u',
        ]);
    
        $quizId = $request->quizId;
        $answer = $request->answer;
    
        $quiz = Quiz::findOrFail($quizId);
    
        // Lấy tên file đáp án
        $correctAnswer = pathinfo($quiz->file, PATHINFO_FILENAME);
    
        if ($answer === $correctAnswer) {
            // Nếu đúng, đọc nội dung từ file và gửi về
            $fileContent = file_get_contents(public_path("files/quiz/{$quiz->file}"));
            return response()->json([
                'status' => 200,
                'content' => $fileContent,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Đáp án không chính xác.',
            ], 400);
        }
    }
    
    public function getTotalQuizzesCount()
    {
        $totalQuizzesCount = Quiz::count();
        return response()->json(['total_quizzes_count' => $totalQuizzesCount]);
    }
}
