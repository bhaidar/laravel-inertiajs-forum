<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;

class ForumIndexController extends Controller
{
    public function __invoke()
    {
        return inertia()->render('Forum/Index', [
            'discussions' => DiscussionResource::collection(
                Discussion::with(['topic', 'post', 'latestPost.user', 'participants'])
                    ->orderByPinned()
                    ->latest() // Remove when implemented ordering by last post
                    ->paginate(10)
            ),
        ]);
    }
}
