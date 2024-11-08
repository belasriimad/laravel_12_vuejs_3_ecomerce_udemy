<template>
    <div class="col-md-6">
        <div class="card mb-2" style="max-width: 320px">
            <img :src="product.thumbnail" class="card-img-top" 
                :alt="product.name" height="279">
            <div class="card-body">
                <router-link class="text-decoration-none text-dark"
                    :to="`/product/${product.slug}`">
                    <h5 class="card-title">{{ product.name }}</h5>
                </router-link>
                <p class="card-text" v-dompurify-html="product.desc.substr(0,50)"></p>
                <div class="d-inline-flex mb-2">
                    <span class="badge text-bg-light">
                        <i class="bi bi-tag"></i>
                        {{ product.category.name }}
                    </span>
                    <span class="badge text-bg-light ms-3">
                        <i class="bi bi-c-circle"></i>
                        {{ product.brand.name }}
                    </span>
                </div>
                <div class="my-2">
                    <span class="badge bg-success" v-if="product.status">
                        In Stock
                    </span>
                    <span class="badge bg-warning" v-else>
                        Out Stock
                    </span>
                </div>
                <div v-if="product.reviews.length > 0">
                    <StarRating
                        v-model:rating="reviewAvg"
                        :show-rating="false"
                        read-only
                        :star-size="24"
                    />
                    <small class="text-muted">
                        {{ product.reviews.length }}
                        {{ product.reviews.length > 1 ? "reviews" : "review"}}
                    </small>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between bg-light">
                <router-link :to="`/product/${product.slug}`" class="btn btn-danger btn-sm">
                   <i class="bi bi-cart-plus"></i> Add to Cart
                </router-link>
                <button class="btn btn-outline-danger btn-sm"
                    @click="favoritesStore.addToFavorites(product)"
                    v-if="!favoritesStore.checkIfProductAlreadyAddedToFavorites(product)"
                >
                    <i class="bi bi-heart"></i>
                </button>
                <button class="btn btn-outline-danger btn-sm"
                    @click="favoritesStore.addToFavorites(product)"
                    v-else
                >
                    <i class="bi bi-heart-fill"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed } from "vue"
    import StarRating from "vue-star-rating"
    import { useFavoritesStore } from "../../stores/useFavoritesStore"

    //define the store
    const favoritesStore = useFavoritesStore()

    //define the props
    const props = defineProps({
        product: {
            type: Object,
            required: true
        }
    })

    //calculate the average reviews of the product
    const reviewAvg = computed(() => props.product.reviews.reduce((acc,review) => acc + review.rating / props.product.reviews.length,0))
</script>

<style scoped>
</style>