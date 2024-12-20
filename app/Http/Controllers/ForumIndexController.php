<?php

namespace App\Http\Controllers;

use App\Http\QueryFilters\MentionedQueryFilter;
use App\Http\QueryFilters\MineQueryFilter;
use App\Http\QueryFilters\NoRepliesQueryFilter;
use App\Http\QueryFilters\ParticipantsQueryFilter;
use App\Http\QueryFilters\SolvedQueryFilter;
use App\Http\QueryFilters\TopicQueryFilter;
use App\Http\QueryFilters\UnsolvedQueryFilter;
use App\Http\Resources\DiscussionResource;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ForumIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return inertia()->render('Forum/Index', [
            'query' => (object) $request->query(),
            'discussions' => DiscussionResource::collection(
                QueryBuilder::for(Discussion::class)
                    ->allowedFilters($this->allowedFilters())
                    ->with(['topic', 'post', 'latestPost.user', 'participants'])
                    ->withCount('replies')
                    ->orderByPinned()
                    ->orderByLastPost()
                    ->tap(function ($builder) use ($request) {
                        if (filled($request->search)) {
                            $models = Discussion::search($request->search)->get();

                            return $builder->whereIn('id', $models->pluck('id'));
                        }

                        return $builder;
                    })
                    ->paginate(3)
                    ->appends($request->query())
            ),
        ]);
    }

    protected function allowedFilters(): array
    {
        return [
            AllowedFilter::custom('mentioned', new MentionedQueryFilter),
            AllowedFilter::custom('unsolved', new UnsolvedQueryFilter),
            AllowedFilter::custom('solved', new SolvedQueryFilter),
            AllowedFilter::custom('noreplies', new NoRepliesQueryFilter),
            AllowedFilter::custom('mine', new MineQueryFilter),
            AllowedFilter::custom('participating', new ParticipantsQueryFilter),
            AllowedFilter::custom('topic', new TopicQueryFilter),
        ];
    }
}
