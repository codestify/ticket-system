<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class GenerateTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate tickets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Ticket::factory()->create();
        return 0;
    }
}
