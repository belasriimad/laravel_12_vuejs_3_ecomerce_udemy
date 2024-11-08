<template>
    <div class="row">
        <div class="d-flex">
            <div class="mb-3">
                Found
                <span class="fw-bold">{{ productsStore.products.length }}</span>
                {{ productsStore.products.length > 1 ? "products" : "product"}}
            </div>
            <div class="ms-1" v-if="productsStore.filter">
                for <span class="fw-bold">
                    {{ productsStore.filter.param }} {{ productsStore.filter.value }}
                </span>
            </div>
        </div>
        <ProductListItem 
            v-for="product in productsStore.products.slice(0,data.productsToShow)"
            :key="product.id"
            :product="product"
        />
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-sm btn-dark mt-3"
                v-if="data.productsToShow < productsStore.products.length"
                @click="loadMoreProducts"
                >
                <i class="bi bi-arrow-clockwise"></i> Load more
            </button>
        </div>
    </div>
</template>

<script setup>
    import ProductListItem from "./ProductListItem.vue"
    import { useProductsStore } from "../../stores/useProductsStore"
    import { reactive } from "vue"

    //define the store variable
    const productsStore = useProductsStore()

    //define how many products to show on the home page
    const data = reactive({
        productsToShow: 6
    })

    //define the function to load more products
    const loadMoreProducts = () => {
        if(data.productsToShow < productsStore.products.length) {
            data.productsToShow = data.productsToShow + 6
        }else {
            return 
        }
    }
</script>

<style scoped>
</style>