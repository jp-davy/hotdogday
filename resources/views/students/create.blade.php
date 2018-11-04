@inject('nextHotDogDay', 'App\Http\Utilities\NextHotDogDay')
@inject('hotDogMonth', 'App\Http\Utilities\HotDogMonth')

@extends('layouts.base')

@section('title')
    Get Your Dawgs
@endsection

@section('content')
    <div class="container mt-3">
        <div class="" id="orderInfo">
            <h1 class="text-center display-3 mb-3 d-none d-md-block">
                {{ config('app.name') }}
            </h1>
            <h1 class="text-center mb-3 d-xs-block d-md-none d-lg-none d-xl-none">
                {{ config('app.name') }}
            </h1>

            <h2 class="text-center subtitle  text-uppercase">
                <span class="small text-muted">This Will Be For</span><br>
                @foreach($hotDogMonth->whatDays() as $day)
                    {{ $day->event_date->format('D, M jS') }}<br>
                @endforeach
            </h2>
            <div class="row">
                <div class="col-md-8 mx-auto alert alert-primary text-center">
                    
                        This order is due before {{ $hotDogMonth->dueDate()->format('D, M jS') }} 8:15 AM.
                    
                </div>
            </div>
            
            <p class="my-3 text-center text-info">
                Meal - @{{ (mealPrice/100).toLocaleString('en-US', {style:'currency', currency:'USD'}) }}/ea. - includes hot dog in a bun, chips, milk or bottled water, and dessert.<br>
                <span style="font-size:2rem;">🌭🍟🥛🍪</span>
            </p>
            

           
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card py-3 rounded-0 border-0">
                        <div class="card-header mb-4">
                            <order-user-component></order-user-component>
                        </div>
                        <div class="card-body">
                            
                            <p class="text-left text-muted" v-if="students.length <= 0">No students. Add one below!</p>
                            <div v-for="student in students" v-bind:key="student.id" v-bind:student="student">
                                <student-component :student="student"></student-component>
                            </div>
                            <div class="row justify-content-center align-items-center mt-5">
                                <div class="col-md-6 text-center p-4">
                                    <div class="font-weight-bold text-uppercase mb-2" style="letter-spacing: 0.05rem;">
                                        Add Student <span class="">(Name &amp; Grade)</span>
                                    </div>
                                    <div class="form-inline  justify-content-center">
                                        <label for="name" class="sr-only">Name &amp; Grade</label>
                                        <div class="input-group">
                                            <input type="text" v-model="form.name" @keyup.enter="onSubmit()" class="form-control form-control-lg" placeholder="Name & Grade...">
                                            <div class="input-group-append w-auto">
                                                
                                                    <button class="btn btn-outline-secondary " @click="onSubmit()"><span class=""><i class="fa fa-plus"></i></span></button>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>   
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col-md-6 text-center mb-4">

                                    <h2 class="card-title display-4 text-success mb-0">@{{ (grandTotalCost/100).toLocaleString("en-US", {style:"currency", currency:"USD"}) }}</h2>
                                    <span class="font-weight-bold">Grand Total</span>
                                </div>
                                <div class="col-md-6 ml-auto text-center">
                                    <ul class="text-left">
                                        <li v-if="user.name == ''" class="text-danger">
                                            Please put your last name at the top
                                        </li>
                                        <li v-if="students.length <= 0" class="text-danger">
                                            Please add students above
                                        </li>
                                    </ul>
                                    <ul class="list-inline">
                                        <li class="list-inline-item mb-2">
                                            
                                                
                                                <a role="button" href="{{ route('orders.show', ['user'=>$user]) }}" class="btn btn-lg btn-secondary" v-if="students.length > 0 && user.name != ''">
                                                    Print <span class="ml-3 btn-label btn-label-right float-right"><i class="fa fa-print"></i></span>
                                                </a>
                                            
                                        </li>
                                        <li class="list-inline-item mb-2">
                                            <form action="{{ route('orders.submit-to-school', ['user'=>$user]) }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="submit_to_school" value="true">
                                                <button type="submit" class="btn btn-lg btn-primary" v-if="students.length > 0 && user.name != ''">
                                                    Email It To Me
                                                    <span class="ml-3 btn-label btn-label-right float-right"><i class="fa fa-send-o"></i></span>
                                                </button>
                                        </li>
                                        
                                    </ul>
                                    
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <p class="text-center">
                    Cash or check made out to the school is acceptable for payment, or pay online through the <a href="{{ config('hotdogday.pay_online_url') }}" target="_blank" title="Tuiton & Fees Page">Tuition &amp; Fees Page</a>. 
                    </p>
                    
                    
                    
                    
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
        var daysThisMonth = {{ $hotDogMonth->whatDays()->count() }};
        var hotDogDays = {!! $hotDogMonth->whatDays()->toJson() !!};
    </script>
@endsection