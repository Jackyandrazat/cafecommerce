<template>
    <section class="carousel-section py-8 px-4">
        <div class="container mx-auto">
            <!-- Navigation Tabs -->
            <div class="tabs flex justify-center gap-4 mb-6">
                <Button
                    :label="'Best Seller'"
                    :class="{'p-button-success': activeTab === 'bestseller', 'p-button-outlined': activeTab !== 'bestseller'}"
                    @click="activeTab = 'bestseller'" />
                <Button
                    :label="'New Arrivals'"
                    :class="{'p-button-info': activeTab === 'new', 'p-button-outlined': activeTab !== 'new'}"
                    @click="activeTab = 'new'" />
            </div>

            <!-- Best Seller Carousel -->
            <Carousel v-if="activeTab === 'bestseller'" :value="bestSellerProducts" :numVisible="3" :numScroll="1" :responsiveOptions="responsiveOptions">
                <template #item="slotProps">
                    <div class="product-card border border-surface-200 dark:border-surface-700 rounded p-4 shadow-md">
                        <div class="relative mb-4">
                            <img :src="slotProps.data.image" :alt="slotProps.data.name"
                                class="w-full h-48 object-cover rounded" />
                            <Tag :value="'BEST SELLER'" severity="success"
                                class="absolute top-2 left-2 px-2 py-1 text-xs font-bold" />
                        </div>
                        <h3 class="font-semibold text-lg mb-2">{{ slotProps.data.name }}</h3>
                        <p class="text-gray-500 text-sm mb-2">{{ slotProps.data.size }}</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-red-500 font-bold line-through">${{ slotProps.data.oldPrice }}</span>
                                <span class="text-green-500 font-bold ml-2">${{ slotProps.data.newPrice }}</span>
                            </div>
                            <span>
                                <Button icon="pi pi-heart" severity="secondary" outlined />
                                <Button icon="pi pi-shopping-cart" class="ml-2"/>
                            </span>
                        </div>
                    </div>
                </template>
            </Carousel>

            <!-- New Products Carousel -->
            <Carousel v-if="activeTab === 'new'" :value="newProducts" :numVisible="3" :numScroll="1" :responsiveOptions="responsiveOptions">
                <template #item="slotProps">
                    <div class="product-card border border-surface-200 dark:border-surface-700 rounded p-4 shadow-md">
                        <div class="relative mb-4">
                            <img :src="slotProps.data.image" :alt="slotProps.data.name"
                                class="w-full h-48 object-cover rounded" />
                            <Tag :value="'NEW ARRIVAL'" severity="info"
                                class="absolute top-2 left-2 px-2 py-1 text-xs font-bold" />
                        </div>
                        <h3 class="font-semibold text-lg mb-2">{{ slotProps.data.name }}</h3>
                        <p class="text-gray-500 text-sm mb-2">{{ slotProps.data.size }}</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-green-500 font-bold">${{ slotProps.data.price }}</span>
                            </div>
                            <span>
                                <Button icon="pi pi-heart" severity="secondary" outlined />
                                <Button icon="pi pi-shopping-cart" class="ml-2"/>
                            </span>
                        </div>
                    </div>
                </template>
            </Carousel>
        </div>
    </section>
</template>
<script setup>
import { ref } from 'vue';
import Carousel from 'primevue/carousel';
import Button from 'primevue/button';
import Tag from 'primevue/tag';

// State untuk Tabs
const activeTab = ref('bestseller');

// Produk Best Seller
const bestSellerProducts = ref([
    {
        id: 1,
        name: 'Coffee Retail Packs',
        size: '500g',
        image: 'https://placehold.co/300x300',
        oldPrice: 14.99,
        newPrice: 10.49,
    },
    {
        id: 2,
        name: 'Brazil Blend Arabica',
        size: '500g',
        image: 'https://placehold.co/300x300',
        oldPrice: 13.99,
        newPrice: 11.89,
    },
    {
        id: 3,
        name: 'Unicorn Blood Dark',
        size: '500g',
        image: 'https://placehold.co/300x300',
        oldPrice: 16.50,
        newPrice: 12.38,
    },
]);

// Produk Baru
const newProducts = ref([
    {
        id: 4,
        name: 'Golden Espresso',
        size: '250g',
        image: 'https://placehold.co/300x300',
        price: 8.99,
    },
    {
        id: 5,
        name: 'Caramel Macchiato Blend',
        size: '250g',
        image: 'https://placehold.co/300x300',
        price: 9.49,
    },
    {
        id: 6,
        name: 'Mocha Supreme',
        size: '250g',
        image: 'https://placehold.co/300x300',
        price: 10.99,
    },
]);

// Opsi Responsif Carousel
const responsiveOptions = ref([
    {
        breakpoint: '1024px',
        numVisible: 3,
        numScroll: 1,
    },
    {
        breakpoint: '768px',
        numVisible: 2,
        numScroll: 1,
    },
    {
        breakpoint: '560px',
        numVisible: 1,
        numScroll: 1,
    },
]);
</script>

<style scoped>
.carousel-section {
    background-color: var(--section-bg);
    color: var(--text-primary);
    padding: 2rem 0;
}

.tabs {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.product-card {
    background-color: var(--card-bg);
    border-radius: 8px;
    transition: transform 0.2s ease-in-out;
    text-align: center;
    padding: 1rem;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-card img {
    border-radius: 8px;
}

/* Tema Gelap */
.carousel-section {
    --section-bg: #ffffff;
    --text-primary: #333333;
    --card-bg: #f9fafb;
}

.carousel-section.dark {
    --section-bg: #1f2937;
    --text-primary: #ffffff;
    --card-bg: #374151;
}
</style>

