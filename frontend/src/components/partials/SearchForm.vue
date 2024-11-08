<template>
    <div class="mb-3 d-flex">
        <input type="text" 
            v-model="data.term" 
            class="form-control rounded-0"
            placeholder="Search..."    
        >
        <button class="btn btn-sm btn-dark search__button"
            @click="searchForProducts"
            :disabled="!data.term"
            >
            <i class="bi bi-search"></i>
        </button>
    </div>
</template>

<script setup>
    import { reactive } from "vue"
    import { useProductsStore } from "../../stores/useProductsStore"

    //define store
    const productsStore = useProductsStore()

    //define the data object
    const data = reactive({
        term: ''
    })

    //search function
    const searchForProducts = () => {
        productsStore.filterProducts("find",data.term,true)
        data.term = ''
    }
</script>

<style scoped>
    .search__button{
        border-top-right-radius: 15px;
        border-bottom-right-radius: 15px;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>