<?php

namespace App\Http\Resources;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @mixin Discussion
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'is_pinned' => $this->isPinned(),
            //'replies_count' => $this->replies_count.' '.Str::plural('reply', $this->replies_count),
            'replies_count' => $this->replies_count,
            'post' => PostResource::make($this->whenLoaded('post')),
            'solution' => PostResource::make($this->whenLoaded('solution')),
            'latest_post' => PostResource::make($this->whenLoaded('latestPost')),
            'participants' => PublicUserResource::collection($this->whenLoaded('participants')),
            'user_can' => [
                'reply' => auth()->check() && auth()->user()->can('reply', $this->resource),
                'delete' => auth()->check() && auth()->user()->can('delete', $this->resource),
                'solve' => auth()->check() && auth()->user()->can('solve', $this->resource),
            ],
        ];

    }
}
