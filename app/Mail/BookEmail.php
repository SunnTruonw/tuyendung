<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Setting;
class BookEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $review;
    private $setting;

    public function __construct($review)
    {
        //
        $this->review=$review;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settingM=new Setting();
        $content=$settingM->find(113);

        return $this->view('emails.book',['review'=>$this->review,'content'=>$content]);
    }
}
