<template>
    <select
        v-model="model"
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    >
        <slot />
    </select>
</template>

<script setup>
const model = defineModel();
</script>
