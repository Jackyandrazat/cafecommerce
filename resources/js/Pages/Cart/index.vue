<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>

        <div v-if="cartItems.length">
            <!-- Daftar Produk -->
            <table class="w-full border">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in cartItems" :key="item.id">
                        <td>{{ item.product.name }}</td>
                        <td>
                            <input
                                v-model.number="item.quantity"
                                @change="updateQuantity(item)"
                                type="number"
                                min="1"
                                class="border p-2 w-16 text-center"
                            />
                        </td>
                        <td>{{ formatCurrency(item.price) }}</td>
                        <td>
                            {{ formatCurrency(item.price * item.quantity) }}
                        </td>
                        <td>
                            <button
                                @click="removeItem(item.id)"
                                class="text-red-500 hover:underline"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Total Harga -->
            <div class="mt-4 text-right">
                <p class="text-lg font-bold">
                    Total: {{ formatCurrency(total) }}
                </p>
            </div>

            <!-- Tombol Checkout -->
            <div class="mt-4 text-right">
                <button
                    @click="goToCheckout"
                    class="bg-green-500 text-white py-2 px-4 rounded-md"
                >
                    Lanjutkan ke Checkout
                </button>
            </div>
        </div>

        <div v-else>
            <p>Keranjang Anda kosong.</p>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { defineProps } from "vue";
import { route } from "ziggy-js";

defineProps({
    cartItems: Array,
    total: Number,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};

// Fungsi untuk Update Jumlah
const updateQuantity = (item) => {
    router.patch(route("cart.update", item.id), {
        quantity: item.quantity,
    });
};

// Fungsi untuk Hapus Produk
const removeItem = (id) => {
    router.delete(route("cart.destroy", id));
};

// Navigasi ke Halaman Checkout
const goToCheckout = () => {
    router.get(route('checkout.index')); // Mengarahkan ke halaman Checkout
};
</script>
