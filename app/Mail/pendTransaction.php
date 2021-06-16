<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class pendTransaction extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $msg;
    protected $student;
    protected $course;

    public function __construct($msg, $student, $course)
    {
        $this->msg = $msg;
        $this->student = $student;
        $this->course = $course;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg = $this->msg;
        $student = $this->student;
        $course = $this->course;
        return $this->markdown('admin.email.pendTransaction', compact('msg', 'student', 'course'));
    }
}
