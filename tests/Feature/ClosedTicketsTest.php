<?php

namespace Tests\Feature;

use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ClosedTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function closed_tickets_can_be_retrieved_successfully()
    {
        Ticket::factory()->count(10)->closed()->create();

        $response = $this->get('/api/closed-tickets')
            ->assertOk()->json();

        $ticketResource = TicketResource::collection(
            Ticket::with('user')->closed()->latest()->paginate(10)
        );
        $ticketResourceResponse = $ticketResource->response()->getData(true);

        $this->assertEquals($response, $ticketResourceResponse);
    }

    /** @test * */
    public function closed_tickets_retrieved_has_correct_data_structure()
    {
        Ticket::factory()->count(4)->create();
        Ticket::factory()->count(5)->closed()->create();

        $response = $this->get('/api/closed-tickets')
            ->assertOk()->json();

        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertArrayHasKey('links', $response);

        $this->assertCount(5, $response['data']);
        $this->assertArrayHasKey('status', Arr::first($response['data']));
        $this->assertSame('closed', Arr::first($response['data'])['status']);
        $this->assertArrayHasKey('user_name', Arr::first($response['data']));
        $this->assertArrayHasKey('user_email', Arr::first($response['data']));
        $this->assertArrayHasKey('subject', Arr::first($response['data']));
        $this->assertArrayHasKey('content', Arr::first($response['data']));
        $this->assertArrayHasKey('created_at', Arr::first($response['data']));

    }
}
