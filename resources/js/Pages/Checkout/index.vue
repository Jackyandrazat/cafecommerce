<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Checkout</h1>

        <!-- Formulir Checkout -->
        <form @submit.prevent="processCheckout">
            <!-- Informasi Pengguna -->
            <div class="mb-4">
                <label for="name" class="block font-bold">Nama:</label>
                <input v-model="form.name" id="name" type="text" class="border p-2 rounded-md w-full" required />
            </div>
            <div class="mb-4">
                <label for="address" class="block font-bold">Alamat:</label>
                <textarea v-model="form.address" id="address" class="border p-2 rounded-md w-full" rows="3"
                    required></textarea>
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-4">
                <label class="block font-bold">Metode Pembayaran:</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2">
                        <input v-model="form.payment_method" type="radio" value="cod" required />
                        COD (Bayar di Tempat)
                    </label>
                    <label class="flex items-center gap-2">
                        <input v-model="form.payment_method" type="radio" value="qris" required />
                        QRIS
                    </label>
                    <label class="flex items-center gap-2">
                        <input v-model="form.payment_method" type="radio" value="midtrans" required />
                        Midtrans
                    </label>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="mt-4">
                <h2 class="text-xl font-bold">Ringkasan Pesanan</h2>
                <table class="w-full border mt-2">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in cart" :key="item.id">
                            <td>{{ item.name }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>{{ formatCurrency(item.price * item.quantity) }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right mt-4">
                    <p class="text-lg font-bold">
                        Total: {{ formatCurrency(total) }}
                    </p>
                </div>
            </div>

            <!-- Tombol Konfirmasi -->
            <div class="mt-6">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md w-full">
                    Konfirmasi Pesanan
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import { defineProps } from "vue";
import { route } from "ziggy-js";

// Props dari server untuk data cart dan total
const props = defineProps({
    cart: Array,
    total: Number,
});

console.log(props.cart);


// State untuk form checkout
const form = reactive({
    name: "",
    address: "",
    payment_method: "",
});

// Fungsi untuk format currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};

// Fungsi untuk memproses checkout
const toast = useToast(); // Inisialisasi toast

const processCheckout = () => {
    router.post(route("checkout.process"), form, {
        onSuccess: () => {
            // Tampilkan notifikasi sukses pakai PrimeVue Toast
            toast.add({
                severity: 'success',
                summary: 'Berhasil',
                detail: 'Pesanan berhasil dibuat!',
                life: 3000  // durasi tampilan toast (ms)
            });
        },
        onError: (errors) => {
            // Jika ada error dari server (misal stok tidak cukup)
            if (errors.cart) {
                toast.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: errors.cart,
                    life: 3000
                });
            }
            if (errors.stock) {
                toast.add({
                    severity: 'error',
                    summary: 'Error',
                    detail: errors.stock,
                    life: 3000
                });
            }
            // Jika ada error lain, tangani sesuai kebutuhan
            // ...
        },
    });
};


</script>

<style scoped>
.container {
    max-width: 800px;
    margin: 0 auto;
}
</style>
