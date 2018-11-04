<?php

namespace App\Http\Controllers;

use App\Student;
use App\User;
use Illuminate\Http\Request;
use App\Http\Utilities\HotDogMonth;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $user = $user->fresh(['students'  => function ($query) {
                $query->with(['user']);
            }]);

        $numHotDogDaysThisMonth = HotDogMonth::whatDays()->count();
        foreach($user->students as $student) {
            if($student->meals) {
                $meals = [];
                for($i=1; $i <= 5; $i++) {
                    if($i <= $numHotDogDaysThisMonth) $meals[$i-1] = $student->meals[$i-1];
                    else $meals[$i-1] = 0;
                }
                $student->meals = $meals;
            }

            if($student->extras) {
                $extras = [];
                for($i=1; $i <= 5; $i++) {
                    if($i <= $numHotDogDaysThisMonth) $extras[$i-1] = $student->extras[$i-1];
                    else $extras[$i-1] = 0;
                }
                $student->extras = $extras;
            }
            $student->meal_qty = array_sum($student->meals);
            $student->extra_qty = array_sum($student->extras);
            $student->save();
        }
        
        $user = $user->fresh(['students'  => function ($query) {
                $query->with(['user']);
            }]);
        
        return view('students.create', compact(
            'user'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        if($request->name != '') {
            $request->request->add(['user_id'=>$user->id]);
            $student = Student::create($request->only(['name','user_id']));
        }

        return response()->json([
            'student' => $student->fresh(['user'])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Student $student)
    {
        $numHotDogDaysThisMonth = HotDogMonth::whatDays()->count();

        if($request->meals) {
            $meals = [];
            for($i=1; $i <= 5; $i++) {
                if($i <= $numHotDogDaysThisMonth) $meals[$i-1] = $request->meals[$i-1];
                else $meals[$i-1] = 0;
            }
            $request->merge(['meals' => $meals]);
        }

        if($request->extras) {
            $extras = [];
            for($i=1; $i <= 5; $i++) {
                if($i <= $numHotDogDaysThisMonth) $extras[$i-1] = $request->extras[$i-1];
                else $extras[$i-1] = 0;
            }
            $request->merge(['extras' => $extras]);
        }

        $request->request->add(['meal_qty' => array_sum($request->meals)]);
        $request->request->add(['extra_qty' => array_sum($request->extras)]);

        $student->update($request->only(['name','meals','extras','meal_qty','extra_qty']));



        return response()->json([
            'student' => $student
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Student $student)
    {
        $student->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
