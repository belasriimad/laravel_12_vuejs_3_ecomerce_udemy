<template>
    <div class="card mb-2">
        <Spinner :store="productDetailsStore" />
        <div class="card-header bg-white">
            <h5 class="text-center mt-2">
                Add your review
            </h5>
        </div>
        <div class="card-body">
            <form @submit.prevent="addReview" class="mt-5 col-md-10 mx-auto">
                <div class="mb-3">
                    <label for="title" class="form-label">Title*</label>
                    <input
                        type="text"
                        class="form-control"
                        name="title"
                        id="title"
                        :required="true"
                        v-model="data.review.title"
                        aria-describedby="helpId"
                        placeholder="Title"
                    />
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">Review*</label>
                    <textarea class="form-control" 
                        :required="true"
                        v-model="data.review.body"
                        name="body" id="body" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <StarRating
                        v-model:rating="data.review.rating"
                        :show-rating="false"
                    />
                </div>
                <div class="mb-3">
                    <button
                        type="submit"
                        class="btn btn-dark btn-sm"
                        :disabled="data.review.rating === 0"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
    import { reactive } from "vue"
    import { useProductDetailsStore } from "../../stores/useProductDetailsStore"
    import Spinner from "../layouts/Spinner.vue"
    import StarRating from "vue-star-rating"

    //define the store
    const productDetailsStore = useProductDetailsStore() 

    //define the data object
    const data = reactive({
        review: {
            title: '',
            body: '',
            rating: 0
        }
    })

    //add review function
    const addReview = () => {
        productDetailsStore.storeReview(data.review)
        data.review = {
            title: '',
            body: '',
            rating: 0
        }
    }
</script>

<style scoped>
</style>