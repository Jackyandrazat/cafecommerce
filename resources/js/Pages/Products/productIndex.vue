<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>

        <!-- Search & Filter -->
        <div class="flex gap-4 mb-4">
            <input
                v-model="filters.search"
                @input="filter"
                placeholder="Cari produk..."
                class="border p-2 rounded-md w-full"
            />
            <select
                v-model="filters.category"
                @change="filter"
                class="border p-2 rounded-md"
            >
                <option value="">Semua Kategori</option>
                <option value="1">Makanan</option>
                <option value="2">Minuman</option>
            </select>
        </div>

        <!-- Daftar Produk -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div
                v-for="product in products.data"
                :key="product.id"
                class="bg-white p-4 shadow-md rounded-md"
            >
                <img
                    :src="product.image"
                    alt="Product Image"
                    class="w-full h-32 object-cover rounded-md"
                />
                <h2 class="text-lg font-bold mt-2">{{ product.name }}</h2>
                <p class="text-sm text-gray-500">
                    {{ formatCurrency(product.price) }}
                </p>

                <!-- Tombol Lihat Detail -->
                <button
                    @click="goToDetail(product.id)"
                    class="mt-2 w-full bg-green-500 text-white py-1 rounded-md"
                >
                    Lihat Detail
                </button>

                <!-- Tombol Tambah ke Keranjang -->
                <button
                    @click="addToCart(product.id)"
                    class="mt-2 w-full bg-blue-500 text-white py-1 rounded-md"
                >
                    Tambah ke Keranjang
                </button>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-center">
            <pagination :links="products.links" />
        </div>
    </div>
</template>

<script setup>
import { reactive, watch } from "vue";
import { router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useToast } from "primevue/usetoast";


const toast = useToast();

// Ambil props langsung dari defineProps
const props = defineProps({
    products: Object,
    filters: Object,
    layout: AppLayout,
});

// State untuk Filter
const filters = reactive({
    search: props.filters.search || "",
    category: props.filters.category || "",
});

// Fungsi untuk Filter Produk
const filter = () => {
    router.get("/products", filters, { preserveState: true, replace: true });
};

// Fungsi untuk Format Currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};

// Navigasi ke Detail Produk
const goToDetail = (id) => {
    router.visit(`/products/${id}`);
};

// Tambah Produk ke Keranjang
const addToCart = (productId) => {
    router.post(
        "/cart",
        {
            product_id: productId,
            quantity: 1, // Default jumlah
        },
        {
            onSuccess: () => {
                toast.add({
                    severity: "success",
                    summary: "Berhasil",
                    detail: "Produk berhasil ditambahkan ke keranjang.",
                    life: 3000, // Durasi notifikasi dalam milidetik
                });
            },
            onError: () => {
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
    max-width: 1200px;
    margin: 0 auto;
}
</style>
