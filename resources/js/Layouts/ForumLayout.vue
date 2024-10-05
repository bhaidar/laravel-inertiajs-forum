<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateDiscussionForm from '@/Components/Forum/CreateDiscussionForm.vue';
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="mx-auto max-w-7xl grid-cols-7 gap-6 space-y-6 py-12 sm:px-6 md:grid md:space-y-0 lg:px-8"
        >
            <div class="col-span-2">
                <slot name="side" />
            </div>
            <div class="col-span-5">
                <slot />
            </div>
        </div>
    </AuthenticatedLayout>
    <CreateDiscussionForm />
</template>

<style scoped></style>
