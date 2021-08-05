<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'data' => [
                'tickets_count' =>  Ticket::count(),
                'unprocessed_tickets' => Ticket::open()->count(),
                'user_email_with_most_tickets_submitted' => User::userWithHighestCountOfTickets()->email,
                'last_ticket_processed_at' => Ticket::mostRecentProcessedTime()
            ]
        ]);
    }
}
