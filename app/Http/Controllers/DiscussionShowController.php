<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscussionResource;
use App\Http\Resources\PostResource;
use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionShowController extends Controller
{
    protected const MAX_POSTS_PER_PAGE = 8;

    public function __invoke(Request $request, Discussion $discussion)
    {

        if ($postId = $request->input('post')) {
            return redirect()->route('discussions.show', [
                'discussion' => $discussion,
                'page' => $this->getPageForPost($discussion, $postId),
                'postId' => $postId,
            ]);
        }

        $discussion->load(['topic', 'posts']);
        $discussion->loadCount(['replies']);

        return inertia()->render('Forum/Show', [
            'query' => (object) $request->query(),
            'discussion' => DiscussionResource::make($discussion),
            'posts' => PostResource::collection(
                $discussion->posts()
                    ->with(['user'])
                    ->oldest() // latest posts at the bottom
                    ->paginate(self::MAX_POSTS_PER_PAGE)
            ),
            'postId' => (int) $request->postId,
        ]);
    }

    protected function getPageForPost(Discussion $discussion, mixed $postId)
    {
        $index = $discussion->posts->search(fn ($post) => $post->id == $postId);

        return (int) ceil(($index + 1) / self::MAX_POSTS_PER_PAGE);
    }
}
