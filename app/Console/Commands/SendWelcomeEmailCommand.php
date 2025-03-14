<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\SendWelcomeEmail;

class SendWelcomeEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:send-welcome-email-command';
    protected $signature = 'email:welcome {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = 'Send a welcome email to a specific user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User not found.");
            return;
        }

        SendWelcomeEmail::dispatch($user);
        $this->info("Welcome email dispatched to {$email}");
    }
}
