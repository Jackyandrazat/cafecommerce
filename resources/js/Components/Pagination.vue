<!-- Pagination.vue -->
<template>
    <div class="flex gap-2">
        <button
            v-for="(link, index) in links"
            :key="index"
            @click="navigate(link.url)"
            :disabled="!link.url"
            class="px-3 py-1 border rounded"
        >
            <span v-html="link.label"></span>
        </button>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";

defineProps({
    links: Array,
});

const navigate = (url) => {
    if (url) {
        router.visit(url);
    }
};
</script>
