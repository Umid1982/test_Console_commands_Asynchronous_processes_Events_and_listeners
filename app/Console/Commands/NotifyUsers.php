<?php

namespace App\Console\Commands;

use App\Jobs\SendUserNotificationEmail;
use App\Models\User;
use Illuminate\Console\Command;

class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $role = 'admin';

        $users = User::role($role)->get();

        if ($users->isEmpty()) {
            $this->info("No users found with role: $role");
            return;
        }

        foreach ($users as $user) {
            SendUserNotificationEmail::dispatch($user);
        }

        $this->info('Notification emails have been queued successfully.');
    }
}
