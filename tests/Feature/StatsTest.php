<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function stats_can_be_retrieved()
    {
        $userEmailWithMostCreatedTickets = 'user@test.com';
        User::factory([
            'email' => $userEmailWithMostCreatedTickets
        ])->has(Ticket::factory()->count(5))->create();

        User::factory()->has(Ticket::factory()->count(5)->closed())->create();

        $processedTicket = $this->updateTicket();


        $response = $this->get('api/stats')
            ->assertOk()->json();

        $this->assertSame(
            $userEmailWithMostCreatedTickets,
            $response['data']['user_email_with_most_tickets_submitted']
        );
        $this->assertSame(5, $response['data']['unprocessed_tickets']);
        $this->assertSame(10, $response['data']['tickets_count']);
        $this->assertSame(
            $processedTicket->mostRecentProcessedTime(),
            $response['data']['last_ticket_processed_at']
        );

    }

    protected function updateTicket()
    {
        $ticket = Ticket::find(6);
        $ticket->status = true;
        $ticket->touch();
        $ticket->save();
        return $ticket;
    }
}
