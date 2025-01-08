<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>

        <div v-if="cartItems.length">
            <table class="w-full border">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in cartItems" :key="item.id">
                        <td>{{ item.product.name }}</td>
                        <td>
                            <input
                                v-model="item.quantity"
                                @change="updateQuantity(item)"
                                type="number"
                                min="1"
                            />
                        </td>
                        <td>{{ item.price }} IDR</td>
                        <td>
                            <button
                                @click="removeItem(item.id)"
                                class="text-red-500"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p>Keranjang Anda kosong.</p>
        </div>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { defineProps } from "vue";

defineProps({ cartItems: Array });

const updateQuantity = (item) => {
    router.put(`/cart/${item.id}`, { quantity: item.quantity });
};

const removeItem = (id) => {
    router.delete(`/cart/${id}`);
};
</script>
