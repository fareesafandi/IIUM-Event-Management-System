<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteToEventManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:promote-manager {email? : The email of the user to promote}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote a user to event manager role';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            // List all users and let them choose
            $users = User::all(['id', 'name', 'email', 'role']);
            
            if ($users->isEmpty()) {
                $this->error('No users found in the database.');
                return Command::FAILURE;
            }

            $this->info('Available users:');
            $headers = ['ID', 'Name', 'Email', 'Current Role'];
            $this->table($headers, $users->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role ?? 'public',
                ];
            })->toArray());

            $email = $this->ask('Enter the email of the user to promote to event manager');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return Command::FAILURE;
        }

        if ($user->role === User::ROLE_EVENT_MANAGER) {
            $this->warn("User '{$email}' is already an event manager.");
            return Command::SUCCESS;
        }

        $user->update(['role' => User::ROLE_EVENT_MANAGER]);

        $this->info("✓ User '{$email}' has been promoted to event manager!");
        $this->info("They can now create and manage events.");

        return Command::SUCCESS;
    }
}
