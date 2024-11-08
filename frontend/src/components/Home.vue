<template>
    <div class="row my-5">
        <Spinner :store="productsStore" />
        <Sidebar />
        <div class="col-md-8">
            <ProductList />
        </div>
    </div>
</template>

<script setup>
    import { onMounted } from "vue"
    import { useProductsStore } from "../stores/useProductsStore"
    import ProductList from "./products/ProductList.vue"
    import Spinner from "./layouts/Spinner.vue"
    import Sidebar from "./layouts/Sidebar.vue"

    //define the store variable
    const productsStore = useProductsStore()

    //once the component is mounted we call the action
    onMounted(() => productsStore.fetchAllProducts())
</script>

<style scoped>
</style>