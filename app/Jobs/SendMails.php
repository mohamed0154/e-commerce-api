<?php

namespace App\Jobs;

use App\Mail\MailVerified;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;


class SendMails implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

     public function __construct(public User $user)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new MailVerified($this->user));

    }
}
