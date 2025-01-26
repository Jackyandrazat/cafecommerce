<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-800">
        <Navbar />
        <main>
            <Toast />
            <slot />
        </main>
    </div>
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";
import { usePage } from "@inertiajs/vue3";
import FlashMessage from "@/Components/FlashMessage.vue";
import Toast from 'primevue/toast';

// Ambil flash message dari props Inertia
const { flash } = usePage().props;
</script>
