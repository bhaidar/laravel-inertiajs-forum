<script setup>
import useCreatePost from '@/Composables/useCreatePost.js';

const { post } = defineProps({
    post: Object,
});

const { showCreatePostForm } = useCreatePost();
</script>

<template>
    <div
        class="flex items-start space-x-3 overflow-hidden bg-white p-6 text-gray-900 shadow-sm sm:rounded-lg"
    >
        <div class="w-7 flex-shrink-0">
            <img
                v-if="post.user"
                :src="post.user.avatar_url"
                alt=""
                class="h-7 w-7 rounded-full"
            />
        </div>
        <div class="w-full">
            <div>
                <div>
                    {{ post.user?.username || '[user deleted]' }}
                </div>
                <div class="text-sm text-gray-500">
                    Posted
                    <time
                        :datetime="post.created_at.datetime"
                        :title="post.created_at.datetime"
                    >
                        {{ post.created_at.human }}
                    </time>
                </div>
            </div>
            <div class="mt-3">
                <div v-html="post.body_markdown" class="markdown" />
            </div>

            <ul class="mt-6 flex items-center space-x-3">
                <li v-if="post.discussion.user_can.reply">
                    <button
                        type="button"
                        v-on:click="showCreatePostForm(post.discussion)"
                        class="text-sm text-indigo-500"
                    >
                        Reply
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped></style>
