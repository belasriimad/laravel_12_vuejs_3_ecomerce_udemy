<template>
  <div class="mb-3">
    <h6>Brands</h6>
    <ul class="nav d-flex flex-column">
        <li class="nav-item mb-1" v-for="brand in productsStore.brands"
          :key="brand.id">
            <button class="btn btn-sm btn-link text-dark"
              @click="productsStore.filterProducts('brand',brand.slug)"
              >
                {{ brand.name }}
            </button>
        </li>
    </ul>
  </div>
</template>

<script setup>
  import { useProductsStore } from "../../stores/useProductsStore";

  //define the store variable
  const productsStore = useProductsStore()
</script>

<style scoped>
</style>