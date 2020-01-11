<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FileConverted extends Mailable
{
    use Queueable, SerializesModels;

    protected $convert_log;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($convert_log)
    {
        $this->convert_log = $convert_log;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your converted file is ready | ' . env("APP_NAME"))->view('emails.file-converted')->with(['convert_log'=>$this->convert_log]);
    }
}
