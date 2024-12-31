<template>
    <div>
      <h1>Welcome to CafeCommerce</h1>
      <div v-for="product in products" :key="product.id">
        <h2>{{ product.name }}</h2>
        <p>{{ product.price }}</p>
        <button @click="addToCart(product)">Add to Cart</button>
      </div>
    </div>
  </template>

  <script setup>
  import { router } from '@inertiajs/vue3';

  defineProps({
    products: Array,
  });

  function addToCart(product) {
    router.post('/cart/add', {
      id: product.id,
      name: product.name,
      price: product.price,
      quantity: 1,
    });
  }
  </script>
