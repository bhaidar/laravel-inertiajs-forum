<script setup>
const { post } = defineProps({
    post: Object,
});
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
                {{ post.body }}
            </div>
        </div>
    </div>
</template>

<style scoped></style>
