<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-sm">
            <h1 class="text-2xl font-bold mb-4">Login</h1>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        id="email"
                        required
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input
                        v-model="form.password"
                        type="password"
                        id="password"
                        required
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                >
                    Login
                </button>
                <p v-if="errors" class="mt-4 text-red-500">{{ errors }}</p>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";

const form = reactive({
    email: "",
    password: "",
});

const errors = ref(null);

const submit = () => {
    router.post("/login", form, {
        onError: (error) => {
            errors.value = error.email || "Login gagal.";
        },
    });
};
</script>
