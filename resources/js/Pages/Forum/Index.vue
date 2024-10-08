<script setup>
import { Head, router } from '@inertiajs/vue3';
import ForumLayout from '@/Layouts/ForumLayout.vue';
import Select from '@/Components/Select.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Discussion from '@/Components/Forum/Discussion.vue';
import Pagination from '@/Components/Forum/Pagination.vue';
import Navigation from '@/Components/Forum/Navigation.vue';
import _omitBy from 'lodash.omitby';
import _isEmpty from 'lodash.isempty';
import useCreateDiscussion from '@/Composables/useCreateDiscussion.js';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const { discussions, query } = defineProps({
    discussions: Object,
    query: Object,
});

const { form, showCreateDiscussionForm, visible } = useCreateDiscussion();

const selectedTopic = ref('');

const filterTopic = (e) => {
    router.visit('/', {
        data: _omitBy(
            // Don't return properties in the object below
            {
                'filter[topic]': e.target.value,
            },
            _isEmpty, // if the property value is empty
        ),
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <Head title="Forum" />

    <ForumLayout>
        <div class="space-y-6">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <InputLabel for="topic" value="Topic" class="sr-only" />
                        <Select
                            id="topic"
                            v-on:change="filterTopic"
                            v-model="selectedTopic"
                        >
                            <option value="">All topics</option>
                            <option
                                :value="topic.slug"
                                v-for="topic in $page.props.topics"
                                :key="topic.id"
                                :selected="selectedTopic === topic.slug"
                            >
                                {{ topic.name }}
                            </option>
                        </Select>
                        <!-- query.filter?.topic -->
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <template v-if="discussions.data.length">
                    <Discussion
                        v-for="discussion in discussions.data"
                        :key="discussion.id"
                        :discussion="discussion"
                    />
                    <Pagination :pagination="discussions.meta" />
                </template>
            </div>
        </div>

        <template #side>
            <PrimaryButton
                v-on:click="showCreateDiscussionForm"
                class="flex h-10 w-full justify-center"
                v-if="$page.props.auth.user"
                >Start a discussion
            </PrimaryButton>
            <Navigation :query="query" />
        </template>
    </ForumLayout>
</template>
