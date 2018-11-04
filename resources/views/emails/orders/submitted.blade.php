@component('mail::message')
# {{ $user->name }} Family - {{ $hotDogMonth->first()->event_date->format('F') }}

## Payment <span style="color:#28a745!important;">Due by {{ $dueDate->format('l, F jS, Y') }} by 8:15 AM</span>
<br>
### {{ $hotDogMonth->first()->event_date->format('F') }} Hot Dog Days
@foreach($hotDogMonth as $day) 
- {{ $day->event_date->format('l, F jS, Y') }}
@endforeach
<br><br>

@component('mail::table')
| Student   | # of Meals<br><span style="font-size:12px; font-weight: normal">$ {{ number_format(config('hotdogday.meal_price')/100,2) }}/ea.</span>      | # of Extra Dogs<br><span style="font-size:12px; font-weight: normal">$ {{ number_format(config('hotdogday.extra_price')/100,2) }}/ea.</span> |
| :--------- |:---------------:|:---------------:|
@foreach($user->students as $student)
{{ $student->name }}|@foreach($hotDogMonth as $day) {{ $day->event_date->format('M dS') }}: <span style="font-weight:bold">{{ $student->meals[$loop->index] }}</span><br> @endforeach|@foreach($hotDogMonth as $day) {{ $day->event_date->format('M dS') }}: <span style="font-weight:bold">{{ $student->extras[$loop->index] }}</span><br> @endforeach|
@endforeach
|&nbsp;|<div style="font-weight:bold; font-size: 16px; border-top:1px solid #EDEFF2">{{ $user->students->sum('meal_qty') }}</div>|<div style="font-weight:bold; font-size: 16px; border-top:1px solid #EDEFF2;">{{ $user->students->sum('extra_qty') }}</div>|
@endcomponent

# Grand Total: $ {{ number_format(
        (
            ($user->students->sum('meal_qty') * config('hotdogday.meal_price')) 
            + ($user->students->sum('extra_qty') * config('hotdogday.extra_price'))
        )/100, 2) }}
<br>
@component('mail::button', ['url' => config('hotdogday.pay_online_url')])
Pay Online - Tuiton &amp; Fees Page
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
