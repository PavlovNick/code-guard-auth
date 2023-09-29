<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class SendUsersEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected Mailable $mail;

    public function __construct(User $user, Mailable $mail)
    {
        $this->user = $user;
        $this->mail = $mail;
    }

    public function handle(): void
    {
        try
        {
            Mail::to($this->user->email)->send($this->mail);
        }
        catch (Exception $exception)
        {
            Log::error($exception->getMessage() . " [send email]");
        }
    }
}
