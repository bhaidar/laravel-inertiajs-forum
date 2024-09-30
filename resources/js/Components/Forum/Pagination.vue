<script setup>
import { Link } from '@inertiajs/vue3';

const { pagination } = defineProps({
    pagination: Object,
});
</script>

<template>
    <nav class="relative flex justify-center">
        <Link
            v-for="link in pagination.links"
            :key="link.label"
            :href="link.url ?? ''"
            v-html="link.label"
            class="flex items-center justify-center rounded-lg px-3 py-2 text-sm text-gray-600"
            :class="{ 'bg-gray-200': link.active, 'opacity-50': !link.url }"
        />
    </nav>
</template>

<style scoped></style>
