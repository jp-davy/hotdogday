<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->email) {
            flash()->error('Oops!', 'Please enter an email address.');
            return redirect()->route('home');
        }
        $user = User::where('email',$request->email)->first();
        if(!$user) $user = User::create([
            'email' => $request->email, 
            'password'=>Hash::make(Str::uuid()),
            'uuid'=>null
        ]);

        if(!$user->uuid) $user->update(['uuid'=>null]);
        
        if($user->students->count() <= 0)
            flash()->success('Sweet!', 'Now list your students!');
        else flash()->success('Sweet!', 'Now check how many dawgs you want!');

        return redirect()->route('students.create', ['user'=>$user]);
        
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
    public function update(Request $request, User $user)
    {
        if($request->name != '') {
            $user->update(['name'=> $request->name]);
        }

        return response()->json([
            'user' => $user->fresh(['students'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
