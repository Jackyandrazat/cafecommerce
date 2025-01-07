<template>
    <div :class="['landing-page', { dark: isDarkMode }]">

        <!-- Hero Section -->
        <div class="hero flex flex-col md:flex-row items-center justify-center gap-8 p-8">
            <div class="product-image w-full md:w-1/2 flex justify-center">
                <img src="/public/img/HomeGmbr2.png" alt="Coffee Product" class="rounded-lg" />
            </div>
            <div class="hero-text w-full md:w-1/2 text-center md:text-left">
                <p class="text-primary font-bold mb-2">What's new?</p>
                <h1 class="font-bold text-3xl md:text-4xl mb-4">Meet our new coffee!</h1>
                <p class="text-md mb-6">
                    Try one of our signature selections and see what everyone’s talking about or select ‘Catalogue’ at
                    the top of the page to view all the possibilities.
                </p>
                <Button label="Learn more" class="p-button-rounded p-button-warning" />
            </div>
        </div>
        <ProductInfoSection />
        <BestSellerProducts />

        <!-- Footer -->
        <footer class="footer text-center p-4 mt-8">
            <p>© 2024 CoffeeBuy. All rights reserved.</p>
        </footer>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import Button from 'primevue/button';
import ProductInfoSection from './ProductInfoSection.vue';
import BestSellerProducts from './BestSellerProducts .vue';

// State untuk dark mode
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
/* Navbar */
.navbar {
    background: var(--navbar-bg);
    color: var(--text-primary);
}

.logo {
    font-size: 1.5rem;
    font-weight: bold;
}

.menu a {
    text-decoration: none;
    color: var(--text-primary);
    font-weight: 500;
    transition: color 0.3s;
}

.menu a:hover {
    color: #f39c12;
}

.actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Hero Section */
.hero {
    margin-top: 2rem;
}

.hero img {
    width: 100%;
    max-width: 683px;
    border-radius: 12px;
    /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
}

.hero-text h1 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.hero-text p {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
}

/* Footer */
.footer {
    background: var(--navbar-bg);
    color: var(--text-primary);
    margin-top: 2rem;
}

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
