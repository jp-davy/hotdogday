<?php

namespace App\Http\Controllers;

use App\Mail\OrderSubmittedEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitToSchool(Request $request, User $user)
    {
        $user = $user->fresh(['students']);

        if($request->submit_to_school) {
            Mail::to(
                [
                    $user
                ]
            )
                ->queue(new OrderSubmittedEmail($user));
            /*Mail::to(
                [
                    $user,
                    [
                        'email'=>config('hotdogday.submit_to_school_email.email_address'),
                        'name'=>config('hotdogday.submit_to_school_email.name')
                    ]
                ]
            )
                ->queue(new OrderSubmittedEmail($user));*/

            flash()->success('Done!', 'Your order has been sent to you!');
        }

        return redirect()->route('orders.show',['user'=>$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = $user->fresh(['students']);

        return view('orders.show', compact(
            'user'
        ));
    }

    
}
