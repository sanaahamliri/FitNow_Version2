<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $progress = Progress::all();

        $data = [
            'status' => 200,
            'progress' => $progress,
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        if(Auth::check()){
        $request->validate([
            'weight' => 'required',
            'height' => 'required',
            'Arm_Circumference' => 'required',
            'Hip_Circumference' => 'required',
            'Waist_Circumference' => 'required',
        ]);



        Progress::create([
            'userID' => Auth::id(),
            'weight' => $request->weight,
            'height' => $request->height,
            'Arm_Circumference' => $request->Arm_Circumference,
            'Hip_Circumference' => $request->Hip_Circumference,
            'Waist_Circumference' => $request->Waist_Circumference

        ]);


        $data = [
            'status' => 200,
            'message' => 'Data stored successfully',
        ];
        return response()->json($data, 200);
    }else{
            return response()->json([
                'status' => false,
                'msg' => 'not hhh'
            ], 500);
        }
    }

    public function edit(Request $request, $id)
    {

        $validator = $request->validate([
            'weight' => 'required',
            'height' => 'required',
            'Arm_Circumference' => 'required',
            'Hip_Circumference' => 'required',
            'Waist_Circumference' => 'required',
        ]);
        $progress = Progress::find($id);
        $progress->weight = $request->weight;
        $progress->height = $request->height;
        $progress->Arm_Circumference = $request->Arm_Circumference;
        $progress->Hip_Circumference = $request->Hip_Circumference;
        $progress->Waist_Circumference = $request->Waist_Circumference;

        $progress->save();

        $data = [
            'status' => 200,
            'message' => 'Data updated successfully',
        ];
        return response()->json($data, 200);
    }

    public function delete($id)
    {
        $progress = progress::find($id);
        $progress->delete();
        $data = [
            'status' => 200,
            'message' => 'Data deleted successfully',
        ];
        return response()->json($data, 200);
    }

    public function updateStatus(Request $request, progress $progress)
    {
        $userID = Auth::id();
        if ($userID == $progress->userID) {
            $validatedData = $request->validate([
                'status' => 'required',
            ]);

            $success = $progress->update([
                'status' => $validatedData['status'],
            ]);

            if ($success) {
                $data = [
                    'message' => 'status changed succefully!'
                ];
                return response()->json($data, 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
    }


    public function showUserProgress()
    {
        $userID = Auth::id();
        $progress = Progress::where('userID', $userID)->get();

        $data = [
            'progress' => $progress,
        ];
        return response()->json($data, 200);
    }
}