<?php

namespace Tests\Unit;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function open_tickets_can_be_retrieved()
    {
        Ticket::factory()->count(2)->create();
        Ticket::factory()->count(3)->closed()->create();

        $openTickets = Ticket::open()->get();

        $this->assertCount(2, $openTickets);
        $openTickets->each(function ($ticket) {
            $this->assertFalse($ticket->status);
        });
    }

    /** @test * */
    public function closed_tickets_can_be_retrieved()
    {
        Ticket::factory()->count(2)->create();
        Ticket::factory()->count(3)->closed()->create();

        $closedTickets = Ticket::closed()->get();

        $this->assertCount(3, $closedTickets);
        $closedTickets->each(function ($ticket) {
            $this->assertTrue($ticket->status);
        });

    }
}
