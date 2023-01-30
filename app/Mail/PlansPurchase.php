<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlansPurchase extends Mailable
{
    use Queueable, SerializesModels;
    public $customerDetails;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customerDetails)
    {
        $this->customerDetails = $customerDetails;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');

        if(isset($this->customerDetails['isAdmin'])){
            return $this->from('planparchase@bizprospex.com')
                    ->view('emails.planparchaseAdmin');
        }
        return $this->from('planparchase@bizprospex.com')
                    ->view('emails.planparchase');

    }
}
