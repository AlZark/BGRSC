<?php

namespace App\Console\Commands;

use App\Http\Controllers\MessageController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReminderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder created';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //MessageController::createReminder();
        DB::table('messages')->delete();
    }
}
