@inject('nextHotDogDay', 'App\Http\Utilities\NextHotDogDay')
@inject('hotDogMonth', 'App\Http\Utilities\HotDogMonth')

@extends('layouts.base')

@section('title')
    Print Your Order
@endsection

@section('content')
    <div class="container mt-3">
        <div class="" id="orderInfo">
            <h1 class="text-center display-3 mb-3 ">
                {{ config('app.name') }}
            </h1>
            

            <h2 class="text-center subtitle  text-uppercase">
                <span class="small text-muted">This Will Be For</span><br>
                @foreach($hotDogMonth->whatDays() as $day)
                    {{ $day->event_date->format('l, F jS, Y') }}<br>
                @endforeach
            </h2>
            <div class="row">
                <div class="col-md-8 mx-auto mt-5">
                    <p class="text-center lead">
                        Payment &amp; Form Due <span class="font-weight-bold">{{ $hotDogMonth->dueDate()->format('l, F jS, Y') }} by 8:15 AM</span>.
                    </p>
                </div>
            </div>
            
            <div class="row ">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header py-4">
                            <h2>{{ $user->name }} Family
                                <span class="float-right">
                                    <a role="button" href="{{ route('students.create', ['user'=>$user]) }}" class="btn btn-lg btn-outline-secondary d-print-none mr-2">
                                        Back <span class="mr-3 btn-label btn-label-right float-left"><i class="fa fa-arrow-circle-left"></i></span>
                                    </a>
                                    <button class="btn btn-lg btn-primary d-print-none ml-2" onClick="window.print();">
                                        Print <span class="ml-3 btn-label btn-label-right float-right"><i class="fa fa-print"></i></span>
                                    </button>
                                </span>
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th scope="col" class="">Student</th>
                                            <th scope="col" class="text-center">
                                                <span class="small font-weight-normal text-muted">
                                                    $ {{ number_format(config('hotdogday.meal_price')/100,2) }}/ea.
                                                </span><br>
                                                # of Meals<br>
                                                <span style="font-size:1.8rem;">🌭🍟🥛🍪</span>
                                            </th>
                                            <th scope="col" class="text-center">
                                                <span class="small font-weight-normal text-muted">
                                                    $ {{ number_format(config('hotdogday.extra_price')/100,2) }}/ea.
                                                </span><br>
                                                # of Extra Dogs<br>
                                                <span style="font-size:1.8rem;">🌭</span>
                                            </th>
                                            <th scope="col" class="text-center">Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->students as $student)
                                            <tr>
                                                <td class="w-25 lead py-4">
                                                    {{ $student->name }}
                                                </td>
                                                <td class="w-25 lead text-center py-4">
                                                    @foreach($hotDogMonth->whatDays() as $day)
                                                        <div @if($loop->iteration != $hotDogMonth->whatDays()->count()) class="border-bottom" @endif>
                                                            {{ $day->event_date->format('m.d') }} &mdash; <span class="font-weight-bold">{{ $student->meals[$loop->index] }}</span>
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td class="w-25 lead text-center py-4">
                                                    @foreach($hotDogMonth->whatDays() as $day)
                                                        <div @if($loop->iteration != $hotDogMonth->whatDays()->count()) class="border-bottom" @endif>
                                                            
                                                            {{ $day->event_date->format('m.d') }} &mdash; <span class="font-weight-bold">{{ $student->extras[$loop->index] }}</span>
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td class="w-25 lead text-center py-4">
                                                    $ {{ number_format((
                                                        ($student->meal_qty * config('hotdogday.meal_price')) 
                                                        + ($student->extra_qty * config('hotdogday.extra_price')))/100, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="w-75">
                                                &nbsp; 
                                            </td>
                                            <td class="w-25 text-center">
                                                <h2 class="card-title display-4 text-success mb-0">
                                                            $ {{ number_format(
                                                                (
                                                                    ($user->students->sum('meal_qty') * config('hotdogday.meal_price')) 
                                                                    + ($user->students->sum('extra_qty') * config('hotdogday.extra_price'))
                                                                )/100, 2) }}
                                                        </h2>
                                                        <span class="font-weight-bold">Grand Total</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="lead text-center mt-5">
                                Cash or check made out to the school is acceptable for payment, or pay online through the <a href="{{ config('hotdogday.pay_online_url') }}" target="_blank" title="Tuiton & Fees Page">Tuition &amp; Fees Page <i class="fa fa-external-link"></i></a>. 
                            </p>
                        </div>
                        
                    </div>

                    
                    
                    
                    
                    
                </div>
            </div>
            
            
            @include('partials.footer')
            
        </div>
    </div>
@endsection

@section('footer.scripts')
    <script>
        var user = {!! $user->toJson() !!}
        if(!user.students) user.students = [];
        var meal_price = {{ config('hotdogday.meal_price') }};
        var extra_price = {{ config('hotdogday.extra_price') }};
    </script>
@endsection