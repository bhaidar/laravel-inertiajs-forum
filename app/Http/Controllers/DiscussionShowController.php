<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Http\Resources\PostResource;
use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionShowController extends Controller
{
    public function __invoke(Request $request, Discussion $discussion)
    {
        $discussion->load(['topic']);
        $discussion->loadCount(['replies']);

        return inertia()->render('Forum/Show', [
            'query' => (object) $request->query(),
            'discussion' => DiscussionResource::make($discussion),
            'posts' => PostResource::collection(
                $discussion->posts()
                    ->with(['user'])
                    ->oldest() // latest posts at the bottom
                    ->paginate(10)
            ),
        ]);
    }
}
