<?php
//
//namespace App\Jobs;
//
//use App\Mail\PasswordResetMail;
//use Illuminate\Bus\Queueable;
//use Illuminate\Support\Facades\Mail;
//use Illuminate\Queue\SerializesModels;
//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Foundation\Bus\Dispatchable;
//
//
//class SendMail implements ShouldQueue
//{
//    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
//    public $data;
//
//    /**
//     * Create a new job instance.
//     */
//    public function __construct($data)
//    {
//        $this->data = $data;
//    }
//
//    /**
//     * Execute the job.
//     */
//    public function handle(): void
//    {
//        Mail::to($this->data['mail_to'])->send(new PasswordResetMail([
//            'subject' => $this->data['subject'],
//            'message' => $this->data['message'],
//        ]));
//    }
//
//}

namespace App\Jobs;

use App\Mail\PasswordResetMail;
use App\Mail\RegisterMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class RegisterSendingMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $status = false; // Add a status variable

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Mail::to($this->data['mail_to'])->send(new RegisterMail([
                'subject' => $this->data['subject'],
                'message' => $this->data['message'],
            ]));

            // Check for mail failures
            Log::info("Email sent successfully to {$this->data['mail_to']}");


            $this->status = true;


        } catch (\Exception $e) {
            Log::error("Failed to send email to {$this->data['mail_to']}: " . $e->getMessage());
            $this->fail($e);
        }
    }

    /**
     * Return email status after job execution
     */
    public function getStatus()
    {
        return $this->status;
    }
}
