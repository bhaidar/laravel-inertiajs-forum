<script setup>
import Svg from '@/Components/Svg.vue';
</script>

<template>
    <markdown-toolbar class="-ml-px flex items-center">
        <md-bold class="cursor-pointer px-1 py-1.5">
            <Svg name="icon-bold" class="h-5 w-5" />
        </md-bold>
        <md-italic class="cursor-pointer px-1 py-1.5">
            <Svg name="icon-italic" class="h-5 w-5" />
        </md-italic>
        <md-code class="cursor-pointer px-1 py-1.5">
            <Svg name="icon-code" class="h-5 w-5" />
        </md-code>
        <md-link class="cursor-pointer px-1 py-1.5">
            <Svg name="icon-link" class="h-5 w-5" />
        </md-link>
        <md-mention class="cursor-pointer px-1 py-1.5">
          <Svg name="icon-at" class="h-5 w-5" />
        </md-mention>
    </markdown-toolbar>
</template>
