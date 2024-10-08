<script setup>
import FixedFormWrapper from '@/Components/Forum/FixedFormWrapper.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Textarea from '@/Components/Textarea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Svg from '@/Components/Svg.vue';
import useCreatePost from '@/Composables/useCreatePost.js';

const { discussion, form, hideCreatePostForm, visible } = useCreatePost();

const createPost = () => {
    form.post(route('posts.store'), {
        onSuccess: () => {
            form.reset();
            hideCreatePostForm();
        },
    });
};
</script>

<template>
    <FixedFormWrapper
        v-if="visible"
        v-on:submit.prevent="createPost"
        :form="form"
    >
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-medium">
                    Replying to {{ discussion.title }}
                </h1>
                <button v-on:click="hideCreatePostForm">
                    <Svg name="icon-close" class="h-5 w-5" />
                </button>
            </div>
        </template>

        <template v-slot:main="{ markdownPreviewEnabled }">
            <div class="">
                <InputLabel for="body" value="Body" class="sr-only" />
                <Textarea
                    id="body"
                    class="h-48 w-full align-top"
                    v-model="form.body"
                    v-if="!markdownPreviewEnabled"
                />
                <InputError class="mt-2" :message="form.errors.body" />
            </div>
        </template>

        <template v-slot:button>
            <PrimaryButton> Reply</PrimaryButton>
        </template>
    </FixedFormWrapper>
</template>
