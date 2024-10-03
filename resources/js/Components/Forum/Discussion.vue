<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import pluralize from 'pluralize';

const { discussion } = defineProps({
    discussion: Object,
});

const participants = computed(() => discussion.participants.slice(0, 3));
const moreParticipants = computed(() => discussion.participants.length - 3);
</script>

<template>
    <Link
        :href="route('discussions.show', discussion)"
        class="block overflow-hidden bg-white shadow-sm sm:rounded-lg"
    >
        <div class="flex items-center space-x-6 p-6 text-gray-900">
            <div class="flex-grow">
                <div class="flex items-center space-x-3">
                    <span
                        class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-0.5 text-sm text-gray-600"
                    >
                        {{ discussion.topic?.name }}
                    </span>
                    <h1 class="text-lg font-medium">
                        <template v-if="discussion.is_pinned">
                            [Pinned]
                        </template>
                        {{ discussion.title }}
                    </h1>
                </div>
                <div class="mt-3 line-clamp-1 text-sm text-gray-500">
                    {{ discussion.post?.body_preview }}
                </div>
                <template v-if="discussion.latest_post">
                    <Link
                        :href="route('discussions.show', discussion)"
                        class="mt-3 inline-block text-sm"
                    >
                        Last post by
                        {{
                            discussion.latest_post.user?.username ||
                            '[user deleted]'
                        }}
                        at
                        <time
                            :datetime="
                                discussion.latest_post.created_at.datetime
                            "
                            :title="discussion.latest_post.created_at.datetime"
                        >
                            {{ discussion.latest_post.created_at.human }}
                        </time>
                    </Link>
                </template>
                <template v-else>
                    <div class="mt-3 inline-block text-sm">No posts yet!</div>
                </template>
            </div>
            <div class="flex flex-shrink-0 flex-col items-end">
                <div class="flex items-center justify-start -space-x-1">
                    <img
                        :src="participant.avatar_url"
                        v-for="participant in participants"
                        :key="participant.id"
                        :title="participant.username"
                        class="w-6 rounded-full ring-2 ring-white first-of-type:h-7 first-of-type:w-7"
                        alt=""
                    />
                    <span
                        class="!ml-3 text-sm text-gray-600"
                        v-if="moreParticipants > 0"
                        >+ {{ moreParticipants }} more
                    </span>
                </div>
                <div class="mt-3 text-sm">
                    {{ pluralize('reply', discussion.replies_count, true) }}
                </div>
            </div>
        </div>
    </Link>
</template>

<style scoped></style>
