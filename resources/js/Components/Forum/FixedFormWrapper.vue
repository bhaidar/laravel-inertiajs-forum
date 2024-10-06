<template>
    <form
        class="fixed bottom-0 w-full space-y-3 border-t-4 border-gray-100 bg-white p-6"
    >
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div>
                <slot name="header" />
            </div>
            <div class="mt-4">
                <slot name="main" />
                <div class="mt-4">
                    <slot name="button" />
                </div>
            </div>
        </div>
    </form>
</template>

<script setup></script>

<style lang="scss" scoped></style>
