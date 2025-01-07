<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-800">
        <Navbar />
        <main>
            <slot />
        </main>
    </div>
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";
</script>
