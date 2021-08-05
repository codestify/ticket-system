<?php

namespace Tests\Unit;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProcessTicketCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function it_processes_ticket()
    {
        Ticket::factory()->count(5)->create();

        Artisan::call('tickets:process');
        $this->assertCount(4, Ticket::open()->get());

        Artisan::call('tickets:process');
        Artisan::call('tickets:process');
        $this->assertCount(2, Ticket::open()->get());
    }
}
