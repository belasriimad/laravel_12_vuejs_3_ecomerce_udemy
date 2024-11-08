<template>
  <div>
    <Spinner :store="productDetailsStore" />
    <div v-if="productDetailsStore.product">     
        <div class="row my-5">
            <div class="col-md-6">
                <div>
                    <!-- product images -->
                    <vue-image-zoomer 
                        img-class="img-fluid rounded" 
                        :regular="productDetailsStore.product?.thumbnail"
                        :zoom="productDetailsStore.product?.thumbnail"
                    />
                </div>
                <div class="row my-2">
                    <div class="col-md-6"
                        v-for="productImage in productDetailsStore.productImages"
                        :key="productImage.id"
                    >
                        <vue-image-zoomer 
                            img-class="img-fluid rounded" 
                            :regular="productImage.src"
                            :zoom="productImage.src"
                        />
                    </div>
                </div>
            </div>
            <div class="col-md-5 mx-auto">
                <div v-if="productDetailsStore.product?.reviews.length > 0">
                    <StarRating
                        v-model:rating="reviewAvg"
                        :show-rating="false"
                        read-only
                        :star-size="24"
                    />
                    <small class="text-muted">
                        {{ productDetailsStore.product.reviews.length }}
                        {{ productDetailsStore.product.reviews.length > 1 ? "reviews" : "review"}}
                    </small>
                </div>
                <h5 class="my-3">
                    {{ productDetailsStore.product?.name }}
                </h5>
                <div class="d-inline-flex">
                    <span class="badge text-bg-light">
                        <i class="bi bi-tag"></i>
                        {{ productDetailsStore.product?.category.name }}
                    </span>
                    <span class="badge text-bg-light ms-3">
                        <i class="bi bi-c-circle"></i>
                        {{ productDetailsStore.product?.brand.name }}
                    </span>
                </div>
                <p class="my-3" v-dompurify-html="productDetailsStore.product?.desc"></p>
                <div class="mb-2">
                    <span class="h5">
                        ${{ productDetailsStore.product?.price }}
                    </span>
                </div>
                <div class="d-flex flex-wrap justify-content-start">
                    <div 
                        :class="`${data.chosenColor?.id === color.id ? 'border border-light-subtle shadow-sm border-2 rounded' : ''}  mb-1 me-1`" 
                        v-for="color in productDetailsStore.product?.colors"
                        :key="color.id"
                        :style="{
                            backgroundColor:color.name,
                            width:'30px',
                            height:'30px',
                            cursor:'pointer'
                        }"
                        @click="setChosenColor(color)"
                    >
                    </div>
                </div>
                <div class="d-flex flex-wrap justify-content-start align-items-center my-3">
                    <button 
                        :class="`${data.chosenSize?.id === size.id ? 'btn btn-danger mb-3 mx-1 rounded-0' : 'btn btn-sm btn-outline-secondary mb-3 mx-1'}`"
                        v-for="size in productDetailsStore.product?.sizes"
                        :key="size.id"
                        @click="setChosenSize(size)"
                    >
                        {{ size.name }}
                    </button>
                </div>
                <div>
                    <span class="badge bg-success" v-if="productDetailsStore.product?.status">
                        In Stock
                    </span>
                    <span class="badge bg-warning" v-else>
                        Out Stock
                    </span>
                </div>
                <div class="my-3 d-inline-flex">
                    <div>
                        <input type="number" 
                            v-model="data.qty" 
                            min="1"
                            :max="productDetailsStore.product?.qty"
                            class="form-control"
                        >
                    </div>
                    <div class="ms-2">
                        <button class="btn btn-danger btn-block"
                            :disabled="!data.chosenColor || !data.chosenSize || !productDetailsStore.product?.status"
                            @click="cartStore.addToCart({
                                ref: makeUniqueId(10),
                                product_id: productDetailsStore.product?.id,
                                name: productDetailsStore.product?.name,
                                slug: productDetailsStore.product?.slug,
                                qty: data.qty,
                                price: productDetailsStore.product?.price,
                                color: data.chosenColor?.name,
                                size: data.chosenSize?.name,
                                maxQty: productDetailsStore.product?.qty,
                                image: productDetailsStore.product?.thumbnail,
                                coupon_id: null,
                            })"
                            >
                            <i class="bi bi-cart-plus"></i> Add to cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-8 mx-auto">
                <ReviewList />
                <div v-if="authStore.isLoggedIn">
                    <div v-if="checkIfUserBoughtTheProduct()">
                        <UpdateReview v-if="productDetailsStore.reviewToUpdate.updating" />
                        <AddReview v-else />
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script setup>
    import { computed, onMounted, reactive } from "vue"
    import { useRoute } from "vue-router"
    import { useProductDetailsStore } from "../../stores/useProductDetailsStore"
    import { useCartStore } from "../../stores/useCartStore"
    import Spinner from "../layouts/Spinner.vue"
    import { makeUniqueId } from "../../helpers/config"
    import { useAuthStore } from "../../stores/useAuthStore"
    import AddReview from "../reviews/AddReview.vue"
    import UpdateReview from "../reviews/UpdateReview.vue"
    import ReviewList from "../reviews/ReviewList.vue"
    import StarRating from "vue-star-rating"

    //define the products store
    const productDetailsStore = useProductDetailsStore()
    const cartStore = useCartStore()
    const authStore = useAuthStore()

    //define the route
    const route = useRoute()

    //define the data object
    const data = reactive({
        qty: 1,
        chosenColor: null,
        chosenSize: null
    })

    //set the chosen color by user
    const setChosenColor = (color) => {
        data.chosenColor = color
    }

    //set the chosen size by user
    const setChosenSize = (size) => {
        data.chosenSize = size
    }

    //check if user has bought the product
    const checkIfUserBoughtTheProduct = () => {
        return authStore.user?.orders?.some(order => order.products?.some(item => item.id === productDetailsStore.product.id))
    }

    //calculate the average reviews of the product
    const reviewAvg = computed(() => productDetailsStore.product?.reviews.reduce((acc,review) => acc + review.rating / productDetailsStore.product.reviews.length,0))

    //once the component is mounted we fetch the product
    onMounted(() => productDetailsStore.fetchProduct(route.params.slug))
</script>

<style scoped>
</style>