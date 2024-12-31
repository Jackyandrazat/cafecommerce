<template>
    <div>
        <h1>Welcome to CafeCommerce</h1>

        <!-- Tombol PrimeVue -->
        <Button label="Tambah ke Keranjang" icon="pi pi-shopping-cart" @click="addToCart" />

        <!-- Tabel PrimeVue -->
        <DataTable :value="products" tableStyle="min-width: 50rem">
            <Column field="name" header="Nama Produk"></Column>
            <Column field="price" header="Harga"></Column>
            <Column header="Aksi">
                <template #body="slotProps">
                    <Button icon="pi pi-plus" label="Tambah" @click="addToCart(slotProps.data)" />
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

defineProps({
    products: Array,
});

function addToCart(product) {
    console.log('Produk ditambahkan:', product);
}
</script>

<style>
h1 {
    font-size: 24px;
    margin-bottom: 1rem;
}
</style>
