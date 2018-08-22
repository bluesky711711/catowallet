<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Mail;
class NotifierToAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifier:toadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail to Admin About unallocated users!';

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
     * @return mixed
     */
    public function handle()
    {
      $user = User::all();

      foreach ($user as $a)
      {
        if ($a->wallet_id == '' || !$a->wallet_id)
        Mail::raw("This user has not wallet server connection. user email: ".$a->email, function($message) use ($a)
        {
          $message->from('catowallet@site.com');
          $message->to('jjj092353@gmail.com')->subject('Notification From CatoWallet!');
        });
      }
      $this->info('Email has been sent successfully');
    }
}
