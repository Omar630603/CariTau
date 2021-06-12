<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class replyComment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $msg;
    protected $c;
    public function __construct($msg, $c)
    {
        $this->msg = $msg;
        $this->c = $c;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $c = $this->c;
        $msg = $this->msg;
        return $this->markdown('admin.email.replyComments', compact('msg', 'c'));
    }
}
