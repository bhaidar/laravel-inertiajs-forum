<script setup>
import { ref } from 'vue';

const markdownPreviewEnabled = ref(false);
</script>

<template>
    <form
        class="fixed bottom-0 w-full space-y-3 border-t-4 border-gray-100 bg-white p-6"
    >
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div>
                <slot name="header" />
            </div>
            <div class="mt-4 space-y-3">
                <slot
                    name="main"
                    :markdownPreviewEnabled="markdownPreviewEnabled"
                />
                <div class="flex items-center justify-between">
                    <div>markdown toolbar</div>
                    <div>
                        <button
                            type="button"
                            class="text-sm text-indigo-500"
                            v-on:click="
                                markdownPreviewEnabled = !markdownPreviewEnabled
                            "
                        >
                            {{
                                markdownPreviewEnabled ? 'Turn off' : 'Turn on'
                            }}
                            markdown preview
                        </button>
                    </div>
                </div>
                <div class="mt-4">
                    <slot name="button" />
                </div>
            </div>
        </div>
    </form>
</template>

<style lang="scss" scoped></style>
