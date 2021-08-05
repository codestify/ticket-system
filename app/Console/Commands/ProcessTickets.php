<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class ProcessTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process tickets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ticket = Ticket::open()->latest()->first();
        $ticket->status = true;
        $ticket->touch();
        $ticket->save();
        return 0;
    }
}
