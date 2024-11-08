<template>
  <div class="row my-4">
    <div class="col-md-12">
        <div class="card p-2">
            <div class="card-body" v-if="favoritesStore.favorites.length">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product,index) in favoritesStore.favorites"
                            :key="product.id">
                            <td>{{ index += 1 }}</td>
                            <td>
                                <img :src="product.thumbnail" 
                                    width="60" 
                                    height="60"
                                    class="img-fluid rounded"
                                    :alt="product.name"    
                                >
                            </td>
                            <td>
                                <router-link :to="`/product/${product.slug}`">
                                    {{ product.name }}
                                </router-link>
                            </td>
                            <td>{{ product.price }}</td>
                            <td>
                                <i class="bi bi-bookmark-x"
                                    @click="favoritesStore.addToFavorites(product)"
                                    :style="{cursor: 'pointer'}"
                                ></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Alert v-else bgColor="info" content="Your favorites list is empty !" />
        </div>
    </div>
  </div>
</template>

<script setup>
    import { useFavoritesStore } from "../../stores/useFavoritesStore"
    import Alert from "../layouts/Alert.vue"

    //define the favorites store
    const favoritesStore = useFavoritesStore()
</script>

<style scoped>
</style>