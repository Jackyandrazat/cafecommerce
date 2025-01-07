<template>
    <nav class="bg-white shadow-md dark:bg-gray-900" :class="['landing-page', { dark: isDarkMode }]">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <div class="text-lg font-bold">CoffeeBuy</div>
            <ul class="flex space-x-4">
                <li>
                    <a :href="route('products.index')" class="hover:text-blue-500"
                        >Catalogue</a
                    >
                </li>
                <li>
                    <a href="/delivery" class="hover:text-blue-500">Delivery</a>
                </li>
                <li>
                    <a href="/gift-cards" class="hover:text-blue-500"
                        >Gift Cards</a
                    >
                </li>
                <li>
                    <a href="/about-us" class="hover:text-blue-500">About Us</a>
                </li>
            </ul>
            <div class="flex items-center space-x-2">
                <button class="bg-green-500 text-white px-4 py-2 rounded">
                    Sign in
                </button>
                <button class="text-gray-600 dark:text-gray-300">🛒</button>
                <ToggleSwitch v-model="isDarkMode" class="p-button-rounded" />
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, watch } from "vue";
import { route } from 'ziggy-js';
import ToggleSwitch from 'primevue/toggleswitch';


// Dark Mode Toggle
const isDarkMode = ref(false);

// Watch perubahan mode untuk menambahkan class di body
watch(isDarkMode, (newValue) => {
    if (newValue) {
        document.body.classList.add('dark');
    } else {
        document.body.classList.remove('dark');
    }
});
</script>

<style scoped>
/* nav ul li a {
    @apply text-gray-700 dark:text-gray-200;
} */

/* Responsiveness */
@media (max-width: 768px) {
    .menu {
        display: none;
    }

    .hero {
        flex-direction: column;
    }

    .hero-text {
        text-align: center;
    }
}

/* Dark Mode */
.landing-page {
    --navbar-bg: #ffffff;
    --text-primary: #333333;
    --text-secondary: #555555;
    background-color: #f9fafb;
    color: #333;
}

.landing-page.dark {
    --navbar-bg: #1f2937;
    --text-primary: #ffffff;
    --text-secondary: #e5e7eb;
    background-color: #111827;
    color: #ffffff;
}
</style>
