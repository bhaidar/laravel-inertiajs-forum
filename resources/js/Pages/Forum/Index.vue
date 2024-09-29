<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ForumLayout from "@/Layouts/ForumLayout.vue";
</script>

<template>
  <Head title="Forum" />

  <ForumLayout>
    <div
        class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
    >
      <div class="p-6 text-gray-900">
        {{ $page.props.topics }}
      </div>
    </div>

    <template #side>
      <div
          class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
      >
        <div class="p-6 text-gray-900">
          Side
        </div>
      </div>
    </template>
  </ForumLayout>
</template>
