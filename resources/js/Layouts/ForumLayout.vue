<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
  <AuthenticatedLayout>
    <div class="mx-auto max-w-7xl space-y-6 py-12 md:space-y-0 md:grid grid-cols-7 gap-6 sm:px-6 lg:px-8">
      <div class="col-span-2">
        <slot name="side" />
      </div>
      <div class="col-span-5">
        <slot />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>