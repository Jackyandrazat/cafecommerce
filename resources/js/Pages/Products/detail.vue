<template>
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <img
                    :src="product.image"
                    alt="Product Image"
                    class="w-full h-64 object-cover rounded-md"
                />
            </div>
            <div>
                <h1 class="text-3xl font-bold">{{ product.name }}</h1>
                <p class="text-xl text-gray-500 my-2">
                    {{ product.price }} IDR
                </p>
                <p class="text-gray-700">{{ product.description }}</p>
                <button
                    @click="addToCart"
                    class="mt-4 w-full bg-blue-500 text-white py-2 rounded-md"
                >
                    Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/vue3";

// Props dari server
defineProps({
    product: Object,
});

// Fungsi Tambah ke Keranjang
const addToCart = () => {
    router.post("/cart", { product_id: product.id });
};
</script>

<style scoped>
.container {
    max-width: 800px;
    margin: 0 auto;
}
</style>
