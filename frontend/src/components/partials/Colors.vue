<template>
  <div class="mb-3">
    <h6>Colors</h6>
    <div class="d-flex flex-wrap justify-content-start">
        <div class="border border-light-subtle shadow-sm border-2 rounded mb-1 me-1" 
          v-for="color in productsStore.colors"
          :key="color.id"
          @click="productsStore.filterProducts('color',color.id)"
          :style="{
            backgroundColor:color.name,
            width:'30px',
            height:'30px',
            cursor:'pointer'
          }"
          >
        </div>
    </div>
  </div>
</template>

<script setup>
  import { useProductsStore } from "../../stores/useProductsStore";

  //define the store variable
  const productsStore = useProductsStore()
</script>

<style scoped>
</style>