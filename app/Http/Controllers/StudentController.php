<?php

namespace App\Http\Controllers;

use App\Models\AttendanceList;
use App\Models\Student;
use http\Env\Response;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function list(): \Illuminate\Http\JsonResponse
    {
        try {
            $list = AttendanceList::with(['students'])->first();
            $students = [];

            if ($list->students->count()) {
                foreach ($list->students as $student) {
                    $students[] = [
                        'id' => $student->id,
                        'first_name' => $student->first_name,
                        'last_name' => $student->last_name,
                        'email' => $student->email,
                        'attending' => (bool)$student->pivot->attended,
                    ];
                }
            } else {
                $students = Student::all()->each(function ($student) {
                    $student->attending = false;
                });
            }
            return response()->json($students, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 500]);
        }
    }

    public function updateRoster(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $list = AttendanceList::firstOrCreate();
            $list->students()->sync($request->students);

            return response()->json(['message' => 'The attending list has been updated.', 200]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 500]);
        }
    }
}
