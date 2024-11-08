<template>
    <div class="card mb-2">
        <div class="card-header bg-white">
            <h5 class="text-center mt-2">
                Reviews ({{ productDetailsStore.product.reviews.length }})
            </h5>
        </div>
        <div class="card-body">
            <ul class="mt-4 list-group" v-if="productDetailsStore.product.reviews.length">
                <li class="list-group-item d-flex justify-content-between align-items-center"
                    v-for="review in productDetailsStore.product.reviews"
                    :key="review.id"
                >
                    <img :src="review.user.image_path" 
                        :alt="review.user.name" 
                        width="50"
                        height="50" 
                        class="rounded-circle"   
                    >
                    <div class="ms-2 me-auto">
                        <span class="fw-bold">
                            {{ review.title }}
                        </span>
                        <p class="card-text">
                            {{ review.body }}
                        </p>
                        <div>
                            <small class="text-body-secondary">
                                By {{ review.user.name }} - <span class="text-danger"> {{ review.created_at }}</span>
                            </small>
                        </div>
                        <div>
                            <StarRating
                                v-model:rating="review.rating"
                                :show-rating="false"
                                read-only
                                :star-size="24"
                            />
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-center"
                        v-if="authStore.isLoggedIn && authStore.user.id === review.user_id">
                        <button class="btn btn-sm btn-danger mb-2"
                            @click="productDetailsStore.removeReview(review)"
                            >
                            <i class="bi bi-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-warning mb-2"
                            @click="productDetailsStore.editReview(review)"
                            >
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </li>
            </ul>
            <Alert v-else content="No reviews yet!" bgColor="info" />
        </div>
    </div>
</template>

<script setup>
    import { useAuthStore } from "../../stores/useAuthStore"
    import { useProductDetailsStore } from "../../stores/useProductDetailsStore"
    import StarRating from "vue-star-rating"
    import Alert from "../layouts/Alert.vue"

    //define the stores
    const productDetailsStore = useProductDetailsStore()
    const authStore = useAuthStore()
</script>

<style scoped>
</style>