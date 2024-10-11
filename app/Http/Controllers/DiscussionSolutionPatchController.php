<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscussionSolutionPatchRequest;
use App\Models\Discussion;
use App\Models\Post;

class DiscussionSolutionPatchController extends Controller
{
    public function __invoke(DiscussionSolutionPatchRequest $request, Discussion $discussion)
    {
        // Make sure the post_id is within this topic

        // This acts as a toggle
        // When post_id has a value, you are marking it as the solution
        // When post_id is null, it means you are clearing the solution
        // This will update the 'solution' field in the 'discussions' table to the related post's ID
        // When there is no solution, it will be NULL in the 'discussions' table
        $discussion->solution()->associate(Post::find($request->post_id));
        $discussion->save();

        return back();
    }
}
