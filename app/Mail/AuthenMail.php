<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

class AuthenMail extends Mailable

{

    use Queueable, SerializesModels;

    public $bookMail;

    /**

     * Create a new message instance.

     *

     * @return void

     */

    public function __construct($bookMail)

    {

        $this->bookMail=$bookMail;

    }

    /**

     * Build the message.

     *

     * @return $this

     */

    public function build()

    {

        return $this->subject('Product Enquiry')->view('email.authendication');

    }

}
