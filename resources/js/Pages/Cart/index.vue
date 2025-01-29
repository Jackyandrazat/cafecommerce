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
                        <td>{{ item.product.name }} - Stok: {{ item.product.stock }}</td>
                        <td>
                            <input v-model.number="item.quantity" @change="updateQuantity(item)" type="number" min="1"
                                class="border p-2 w-16 text-center" />
                        </td>
                        <td>{{ formatCurrency(item.price) }}</td>
                        <td>{{ formatCurrency(item.price * item.quantity) }}</td>
                        <td>
                            <button @click="removeItem(item.id)" class="text-red-500 hover:underline">
                                Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Total Harga -->
            <div class="mt-4 text-right">
                <InputText v-model="promoCode" @change="applyPromo" placeholder="Masukkan Kode Promo" />
                <p class="text-lg font-bold">
                    Total: {{ formatCurrency(total) }}
                </p>
            </div>

            <!-- Tombol Checkout -->
            <div class="mt-4 text-right">
                <button @click="goToCheckout" class="bg-green-500 text-white py-2 px-4 rounded-md">
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
import { defineProps, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { useToast } from 'primevue/usetoast'; // 1) import PrimeVue Toast
import InputText from 'primevue/inputtext';

const props = defineProps({
    cartItems: Array,
    total: Number,
});

const promoCode = ref('');
// Inisialisasi Toast
const toast = useToast();

// Fungsi Format Rupiah
const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};

// Fungsi Update Jumlah Item
const updateQuantity = (item) => {
    router.patch(route("cart.update", item.id), {
        quantity: item.quantity,
    });
};

// Fungsi Hapus Item
const removeItem = (id) => {
    router.delete(route("cart.destroy", id));
};

const applyPromo = () => {
    router.post(route('checkout.apply-promo'), { code: promoCode.value }, {
        onError: (errors) => {
            if (errors.promo) {
                toast.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: errors.promo,
                    life: 3000
                });
            }
        },
        onSuccess: (page) => {
            // Jika ada flash success
            if (page.props.flash.success) {
                toast.add({
                    severity: 'success',
                    summary: 'Sukses',
                    detail: page.props.flash.success,
                    life: 3000
                });
            }
        },
    });
};

// Fungsi Navigasi ke Halaman Checkout dengan Validasi Stok
const goToCheckout = () => {
    // 2) Loop cartItems, cek stok
    for (const item of props.cartItems) {
        if (item.quantity > item.product.stock) {
            // 3) Tampilkan Toast Error & batalkan navigasi
            toast.add({
                severity: 'error',
                summary: 'Stok Tidak Cukup',
                detail: `Jumlah produk "${item.product.name}" melebihi stok tersedia.`,
                life: 3000,
            });
            return; // Stop proses, tidak jadi ke Checkout
        }
    }

    // 4) Jika semua valid, baru menuju halaman Checkout
    router.get(route('checkout.index'));
};
</script>
