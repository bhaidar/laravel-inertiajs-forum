<script setup>
import { ref, watch } from 'vue';

const { form } = defineProps({
    form: Object,
});

const markdownPreviewEnabled = ref(false);
const markdownPreviewHtml = ref('');
const markdownPreviewLoading = ref(false);

watch(markdownPreviewEnabled, async (toggled) => {
    if (!toggled) {
        markdownPreviewHtml.value = '';
        return;
    }

    markdownPreviewLoading.value = true;

    // Send a POST request to /markdown to convert the Markdown text to HTML using axios
    try {
        const response = await axios.post(route('markdown.preview'), {
            body: form.body,
        });

        // Update the markdownPreviewHtml ref with the converted HTML
        markdownPreviewHtml.value = response.data.html;
    } catch (error) {
        console.error('Error converting Markdown to HTML:', error);
    } finally {
        markdownPreviewLoading.value = false;
    }
});
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

                <div
                    v-if="markdownPreviewEnabled"
                    class="h-48 overflow-y-scroll rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 shadow-sm"
                    :class="{ 'opacity-50': markdownPreviewLoading }"
                    v-html="markdownPreviewHtml"
                ></div>

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
