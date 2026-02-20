<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldBeUnique;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Queue\SerializesModels;

use App\Mail\SubscriberMail;

use App\Models\Subscribe;

use Mail;

class SendSubscriberEmailJob implements ShouldQueue

{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**

     * Create a new job instance.

     *

     * @return void

     */

    public function __construct($details)

    {

        $this->details = $details;

    }

    /**

     * Execute the job.

     *

     * @return void

     */

    public function handle()

    {

        $email = new SubscriberMail();

        $get_email=Subscribe::get();

        foreach($get_email as $mail){

        $response= Mail::to($mail->email)->send($email);

        }

        $file = fopen("C:/xampp/htdocs/tulia/tulia/public/storage/mail.log","w");

        echo '<pre>';

        var_dump(fwrite($file,$response));

        fclose($file);

    }

}
