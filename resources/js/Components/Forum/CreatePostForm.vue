<script setup>
import FixedFormWrapper from '@/Components/Forum/FixedFormWrapper.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Textarea from '@/Components/Textarea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Svg from '@/Components/Svg.vue';
import useCreatePost from '@/Composables/useCreatePost.js';
import { Mentionable } from 'vue-mention';
import useMentionSearch from '@/Composables/useMentionSearch.js';
import { onUpdated, ref, watch } from 'vue';

const { discussion, form, hideCreatePostForm, user, visible } = useCreatePost();
const { mentionSearch, mentionSearchResults } = useMentionSearch();
const bodyRef = ref(null);

watch(user, (newUser) => {
    if (!newUser) {
        return;
    }

    form.body = `@${newUser.username} ${form.body}`;
});

onUpdated(() => {
    bodyRef.value?.focus();
});

const createPost = () => {
    form.post(route('posts.store', discussion.value), {
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
                <Mentionable
                    :keys="['@']"
                    offset="6"
                    v-on:search="mentionSearch"
                    :items="mentionSearchResults"
                    v-if="!markdownPreviewEnabled"
                >
                    <Textarea
                        id="body"
                        ref="bodyRef"
                        class="h-48 w-full align-top"
                        v-model="form.body"
                    />

                    <template #no-result>
                        <div class="mention-item">No username found</div>
                    </template>
                </Mentionable>

                <InputError class="mt-2" :message="form.errors.body" />
            </div>
        </template>

        <template v-slot:button>
            <PrimaryButton> Reply</PrimaryButton>
        </template>
    </FixedFormWrapper>
</template>
