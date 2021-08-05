<?php

namespace Tests\Unit;


use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GenerateTicketCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function it_generates_ticket()
    {
        Artisan::call('ticket:generate');
        $this->assertCount(1, Ticket::all());

        Artisan::call('ticket:generate');
        Artisan::call('ticket:generate');
        $this->assertCount(3, Ticket::all());
    }
}
