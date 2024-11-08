<template>
    <div class="col-md-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5>Filters</h5>
            <button class="btn btn-link text-dark"
                @click="productsStore.clearFilters"
                >Clear all</button>
        </div>
        <SearchForm />
        <Categories />
        <Brands />
        <Sizes />
        <Colors />
    </div>
</template>

<script setup>
    import Categories from "../partials/Categories.vue"
    import Brands from "../partials/Brands.vue"
    import Colors from "../partials/Colors.vue"
    import Sizes from "../partials/Sizes.vue"
    import SearchForm from "../partials/SearchForm.vue"
    import { useProductsStore } from "../../stores/useProductsStore"

    //define the store
    const productsStore = useProductsStore()
</script>

<style scoped>
</style>