<template>
    <div
        v-if="message"
        :class="className"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 px-4 py-2 rounded shadow-md"
    >
        {{ message }}
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

// Props
defineProps({
    message: String,
    type: {
        type: String,
        default: "success", // Bisa 'success' atau 'error'
    },
});

// Dynamic class
const className = ref("");

watch(
    () => type,
    () => {
        className.value =
            type === "success"
                ? "bg-green-500 text-white"
                : "bg-red-500 text-white";
    }
);
</script>
