<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = [
            'email' => '',
            'name' => '',
            'password' => '',
        ];
        $this->info('This will create a new system user');
        if($this->confirm('Do you want to continue')){
            $user['name'] = $this->ask('Enter name of user');
            $user['email'] = $this->ask('Enter email for user');
            $password = $this->ask('Enter password for user');
            $user['password'] = bcrypt($password);

            if(User::create($user)){
                $this->info('This are no2 saved');
                $this->line('Name: '. $user['name'] );
                $this->line('Email: '. $user['email'] );
                $this->line('Password: '. $password);
            } else {
                $this->error('Something went wrong. Please try agin');
            }
        } else {
            $this->info('Okey, bye!');
        }
    }
}
