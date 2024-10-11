<script setup>
import useCreatePost from '@/Composables/useCreatePost.js';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import Textarea from '@/Components/Textarea.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const { post } = defineProps({
    post: Object,
});

const { showCreatePostForm } = useCreatePost();

const editing = ref(false);
const editForm = useForm({
    body: post.body,
});
const editPost = () => {
    editForm.patch(route('posts.patch', post), {
        onSuccess: () => {
            editing.value = false;
        },
        preserveScroll: true,
    });
};
</script>

<template>
    <div
        :id="`post-${post.id}`"
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
                <form v-if="editing" v-on:submit.prevent="editPost">
                    <InputLabel for="body" value="Body" class="sr-only" />
                    <Textarea
                        id="body"
                        class="h-48 w-full align-top"
                        v-model="editForm.body"
                    />
                    <InputError class="mt-2" :message="editForm.errors.body" />
                    <div class="mt-2 flex items-center space-x-3">
                        <PrimaryButton> Edit</PrimaryButton>
                        <button
                            type="button"
                            v-on:click="editing = false"
                            class="text-sm"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
                <div v-else v-html="post.body_markdown" class="markdown" />
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
                <li v-if="post.user_can.edit">
                    <button
                        v-on:click="editing = true"
                        type="button"
                        class="text-sm text-indigo-500"
                    >
                        Edit
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped></style>
