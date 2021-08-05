<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserTicketsController extends Controller
{
    /**
     * @param $email
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke($email, Request $request): AnonymousResourceCollection
    {
       $user = User::with('tickets')->where('email', $email)->first();
       return TicketResource::collection($user->tickets()->paginate(10));
    }
}
