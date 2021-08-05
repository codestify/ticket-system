<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UserTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function paginated_list_of_tickets_for_certain_email_can_be_retrieved()
    {
        $user_1_email = 'user1@test.com';
        $user_2_email = 'user2@test.com';

        User::factory([
            'email' => $user_1_email
        ])->has(Ticket::factory()->count(5))->create();

        User::factory([
            'email' => $user_2_email
        ])->has(Ticket::factory()->count(5))->create();


        $response = $this->get("/api/users/{$user_1_email}/tickets")
            ->assertOk()->json();

        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('meta', $response);
        $this->assertArrayHasKey('links', $response);

        array_map(function ($ticket) use ($user_1_email, $user_2_email) {
            $this->assertSame($user_1_email, $ticket['user_email']);
            $this->assertTrue($ticket['user_email'] != $user_2_email);
        }, $response['data']);

    }
}
