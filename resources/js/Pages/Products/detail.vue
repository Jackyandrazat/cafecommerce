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
                    {{ formatCurrency(product.price) }}
                </p>
                <p class="text-gray-700">{{ product.description }}</p>
                <div class="mt-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input
                        v-model="quantity"
                        type="number"
                        id="quantity"
                        min="1"
                        class="border rounded-md p-2 w-16"
                    />
                </div>
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
import { defineProps, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";

// Toast untuk notifikasi
const toast = useToast();

// Props dari server
const props = defineProps({
    product: Object,
});

// State jumlah produk yang akan ditambahkan
const quantity = ref(1);

// Fungsi Format Currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};

// Fungsi Tambah ke Keranjang
const addToCart = () => {
    if (quantity.value < 1) {
        toast.add({
            severity: "error",
            summary: "Gagal",
            detail: "Jumlah produk harus minimal 1.",
            life: 3000,
        });
        return;
    }
    if (quantity.value > props.product.stock) {
        toast.add({
            severity: "error",
            summary: "Gagal",
            detail: `Jumlah melebihi stok tersedia (${props.product.stock} unit).`,
            life: 3000,
        });
        return;
    }

    router.post(
        "/cart",
        {
            product_id: props.product.id,
            quantity: quantity.value,
        },
        {
            onSuccess: () => {
                toast.add({
                    severity: "success",
                    summary: "Berhasil",
                    detail: "Produk berhasil ditambahkan ke keranjang.",
                    life: 3000,
                });
            },
            onError: (error) => {
                console.error(error);
                toast.add({
                    severity: "error",
                    summary: "Gagal",
                    detail: "Terjadi kesalahan saat menambah produk ke keranjang.",
                    life: 3000,
                });
            },
        }
    );
};
</script>

<style scoped>
.container {
    max-width: 800px;
    margin: 0 auto;
}
</style>
