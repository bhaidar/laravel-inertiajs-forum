<script setup>
import { onMounted, onUpdated } from 'vue';
import { Head } from '@inertiajs/vue3';
import ForumLayout from '@/Layouts/ForumLayout.vue';
import Post from '@/Components/Forum/Post.vue';
import Pagination from '@/Components/Forum/Pagination.vue';
import Navigation from '@/Components/Forum/Navigation.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import useCreatePost from '@/Composables/useCreatePost.js';
import VueScrollTo from 'vue-scrollto';
import pluralize from 'pluralize';

const { discussion, posts, postId } = defineProps({
    discussion: Object,
    posts: Object,
    postId: Number,
    query: Object,
});

const { form, showCreatePostForm, visible } = useCreatePost();

onMounted(() => scrollToPost(postId));
onUpdated(() => scrollToPost(postId));

const scrollToPost = (postId) => {
    if (!postId) {
        return;
    }

    VueScrollTo.scrollTo(`#post-${postId}`, 500, { offset: -60 });
};
</script>

<template>
    <Head :title="discussion.title" />

    <ForumLayout>
        <div class="space-y-3">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div
                    class="flex items-center justify-between p-6 text-gray-900"
                >
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
                    <div class="text-sm text-gray-600">
                        {{ pluralize('reply', discussion.replies_count, true) }}
                    </div>
                </div>
            </div>

            <template v-if="posts.data.length">
                <Post v-for="post in posts.data" :key="post.id" :post="post" />
                <Pagination :pagination="posts.meta" />
            </template>
        </div>

        <template #side>
            <PrimaryButton
                v-on:click="showCreatePostForm(discussion)"
                class="flex h-10 w-full justify-center"
                v-if="discussion.user_can.reply"
                >Reply to discussion
            </PrimaryButton>
            <Navigation :query="query" />
        </template>
    </ForumLayout>
</template>
