<template>
    <section class="product-info-section">
        <div class="hero flex flex-col md:flex-row items-center justify-center gap-8 p-8">
            <div class="product-image w-full md:w-1/2 flex justify-center">
                <div class="text-content">
                    <h2 class="font-bold text-3xl md:text-4xl mb-4">
                        What’s interesting about this coffee?
                    </h2>
                    <p class="text-md mb-6 leading-relaxed">
                        Try one of our signature selections and see what everyone’s talking about or select ‘Catalogue’
                        at
                        the top of the page to view all the possibilities. Discover the rich flavors and unique aromas
                        that
                        make each cup a memorable experience.
                    </p>
                    <Button label="Read more" class="p-button-rounded p-button-primary" />
                </div>
            </div>
            <div class="hero-text w-full md:w-1/2 text-center md:text-left">
                <div class="image-content">
                    <img src="/public/img/HomeGmbr.png" alt="Coffee Lovers" class="product-img" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import Button from 'primevue/button';
</script>

<style scoped>
/* Base Section Style */
.product-info-section {
    padding: 2rem 1rem;
    background-color: var(--section-bg);
    color: var(--text-primary);
    border-radius: 8px;
    margin: 2rem 0;
}

/* Container untuk Konten */
.container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}

/* Text Content */
.text-content {
    flex: 1;
    min-width: 300px;
    max-width: 50%;
}

.text-content h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.text-content p {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

/* Image Content */
.image-content {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 300px;
    max-width: 85%;
}

.product-img {
    width: 100%;
    max-width: 600px;
    height: auto;
    border-radius: 8px;
    /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
    transition: transform 0.3s ease-in-out;
}

.product-img:hover {
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        flex-direction: column;
        text-align: center;
    }

    .text-content,
    .image-content {
        max-width: 100%;
        min-width: unset;
    }

    .text-content h2 {
        font-size: 1.75rem;
    }

    .product-img {
        max-width: 400px;
    }
}

@media (max-width: 480px) {
    .text-content h2 {
        font-size: 1.5rem;
    }

    .text-content p {
        font-size: 0.9rem;
    }

    .product-img {
        max-width: 350px;
    }
}

/* Dark Mode Support */
.product-info-section {
    --section-bg: #ffffff;
    --text-primary: #333333;
    --text-secondary: #555555;
}

.product-info-section.dark {
    --section-bg: #1f2937;
    --text-primary: #ffffff;
    --text-secondary: #e5e7eb;
    background-color: #1f2937;
    color: #ffffff;
}
</style>
