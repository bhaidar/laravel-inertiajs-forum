<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscussionSolutionPatchRequest;
use App\Models\Discussion;

class DiscussionSolutionPatchController extends Controller
{
    public function __invoke(DiscussionSolutionPatchRequest $request, Discussion $discussion)
    {
        // Make sure the post_id is within this Discussion
        // Or we could add a validation on the form request to validate that the post_id exists in the discussion

        // This acts as a toggle
        // When post_id has a value, you are marking it as the solution
        // When post_id is null, it means you are clearing the solution
        // This will update the 'solution' field in the 'discussions' table to the related post's ID
        // When there is no solution, it will be NULL in the 'discussions' table
        $discussion->solution()->associate($discussion->posts()->find($request->post_id) ?: null);
        $discussion->save();

        return back();
    }
}
