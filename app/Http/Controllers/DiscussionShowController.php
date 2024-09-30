<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionShowController extends Controller
{
    public function __invoke(Request $request, Discussion $discussion)
    {
        $discussion->load(['topic']);

        return inertia()->render('Forum/Show', [
            'discussion' => DiscussionResource::make($discussion),
        ]);
    }
}
