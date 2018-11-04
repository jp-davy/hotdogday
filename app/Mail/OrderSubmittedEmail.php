<?php

namespace App\Mail;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Http\Utilities\NextHotDogDay;
use App\Http\Utilities\HotDogMonth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSubmittedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $nextHotDogDay;
    public $hotDogMonth;
    public $dueDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->nextHotDogDay = NextHotDogDay::whatDay();
        $this->hotDogMonth = HotDogMonth::whatDays();
        $this->dueDate = HotDogMonth::dueDate();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dogMonth = $this->hotDogMonth->first()->event_date->format('F');
        return $this
            ->from(config('hotdogday.mail_from_email.email_address'), config('hotdogday.mail_from_email.name'))
            ->subject(config('app.name').' '.$dogMonth.' - '.$this->user->name.' Family')
            ->markdown('emails.orders.submitted');
    }
}
