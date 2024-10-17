<script setup>
import { Mentionable } from 'vue-mention';
import FixedFormWrapper from '@/Components/Forum/FixedFormWrapper.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from '@/Components/Select.vue';
import Textarea from '@/Components/Textarea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import useCreateDiscussion from '@/Composables/useCreateDiscussion.js';
import useMentionSearch from '@/Composables/useMentionSearch.js';
import InputError from '@/Components/InputError.vue';
import Svg from '@/Components/Svg.vue';

const { form, hideCreateDiscussionForm, visible } = useCreateDiscussion();
const { mentionSearch, mentionSearchResults } = useMentionSearch();

const createDiscussion = () => {
    form.post(route('discussions.store'), {
        onSuccess: () => {
            form.reset();
            hideCreateDiscussionForm();
        },
    });
};
</script>

<template>
    <FixedFormWrapper
        v-if="visible"
        v-on:submit.prevent="createDiscussion"
        :form="form"
    >
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-medium">New discussion</h1>
                <button v-on:click="hideCreateDiscussionForm">
                    <Svg name="icon-close" class="h-5 w-5" />
                </button>
            </div>
        </template>

        <template v-slot:main="{ markdownPreviewEnabled }">
            <div class="flex items-start space-x-3">
                <div class="flex-grow">
                    <div>
                        <InputLabel for="title" value="Title" class="sr-only" />

                        <TextInput
                            id="title"
                            type="text"
                            class="w-full"
                            v-model="form.title"
                            placeholder="Discussion title"
                        />

                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>
                </div>
                <div>
                    <InputLabel for="topic" value="Topic" class="sr-only" />
                    <Select id="topic" v-model="form.topic_id">
                        <option value="">Choose a topic</option>
                        <option
                            :value="topic.id"
                            v-for="topic in $page.props.topics"
                            :key="topic.id"
                        >
                            {{ topic.name }}
                        </option>
                    </Select>
                    <InputError class="mt-2" :message="form.errors.topic_id" />
                </div>
            </div>

            <div class="mt-4">
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
            <PrimaryButton> Start discussion</PrimaryButton>
        </template>
    </FixedFormWrapper>
</template>
