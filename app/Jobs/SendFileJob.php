<?php

namespace App\Jobs;

use App\Helpers\S3Aws;
use App\Helpers\sesVerifyEmail;
use App\Mail\CatalogExported;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;

    protected string $filename;

    protected string $filepath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,string $filename, string $filepath)
    {
        $this->user = $user;
        $this->filename = $filename;
        $this->filepath = $filepath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        (new s3Aws)->s3saveInBucket($this->filename, $this->filepath);
        (new sesVerifyEmail)->verifyEmail();
        Mail::mailer('ses')->to($this->user)->send(new CatalogExported());
        event(new \App\Events\sesSendEmail());
    }
}
