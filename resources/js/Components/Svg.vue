<script setup>
import { defineAsyncComponent } from 'vue';

const { name } = defineProps({
    name: {
        type: String,
        required: true,
    },
});

const icon = defineAsyncComponent(
    () => import(`../../../resources/svg/${name}.svg`),
);
</script>

<template>
    <component :is="icon" />
</template>

<style lang="scss" scoped></style>
