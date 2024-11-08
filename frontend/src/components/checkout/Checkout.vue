<template>
    <div class="row my-3">
        <UpdateUserInfos :updatingProfile="false" />
        <div class="col-md-4">
            <Coupon />
            <ul class="list-group">
                <li class="list-group-item d-flex"
                    v-for="product in cartStore.cartItems"
                    :key="product.ref"
                >
                    <img :src="product.image" 
                        width="60" 
                        height="60"
                        class="img-fluid rounded me-2"
                        :alt="product.name"    
                    >
                    <div class="d-flex flex-column">
                        <h6 class="my-1">
                            <strong>{{ product.name }}</strong>
                        </h6>
                        <span class="text-muted">
                            <strong>Color: {{ product.color }}</strong>
                        </span>
                        <span class="text-muted">
                            <strong>Size: {{ product.size }}</strong>
                        </span>
                    </div>
                    <div class="d-flex flex-column ms-auto">
                        <span class="text-muted">
                            ${{ product.price }} <i>x</i> {{ product.qty }}
                        </span>
                        <span class="text-muted fw-bold">
                            ${{ product.price * product.qty }}
                        </span>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">
                        Discount ({{ cartStore.validCoupon.discount }})%
                    </span>
                    <span class="fw-normal text-danger"
                        v-if="cartStore.validCoupon?.name">
                        {{ cartStore.validCoupon.name }}
                        <i class="bi bi-trash"
                            :style="{
                                cursor: 'pointer'
                            }"
                            @click="removeCoupon"
                        ></i>
                    </span>
                    <span class="fw-bold text-danger">
                        -${{ calculatedDiscount() }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">
                        Total
                    </span>
                    <span class="fw-bold text-danger">
                        ${{ finalTotal() }}
                    </span>
                </li>
            </ul>
            <div class="my-3">
                <Stripe 
                    v-if="authStore.user?.profile_completed"
                />
                <Alert v-else 
                    content="Add your billing details"
                    bgColor="warning"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed, onMounted } from "vue"
    import { useRouter } from "vue-router"
    import { useToast } from "vue-toastification"
    import { useAuthStore } from "../../stores/useAuthStore"
    import { useCartStore } from "../../stores/useCartStore"
    import UpdateUserInfos from "../profile/UpdateUserInfos.vue"
    import Alert from "../layouts/Alert.vue"
    import Coupon from "../coupons/Coupon.vue"
    import Stripe from "../payment/Stripe.vue"
    
    //define the stores
    const cartStore = useCartStore()
    const authStore = useAuthStore()

    //define the router
    const router = useRouter()

    //define the toast
    const toast = useToast()

    //calculate the cart total
    const totalOfCartItems = cartStore.cartItems.reduce((acc,item) => acc += item.price * item.qty,0)
    
    //calculate the discount
    const calculatedDiscount = () => totalOfCartItems * cartStore.validCoupon.discount / 100

    //calculate the final total 
    const finalTotal = () => totalOfCartItems - calculatedDiscount()

    //remove coupon function
    const removeCoupon = () => {
        cartStore.setValidCoupon({
            name: '',
            discount: 0
        })
        //set the coupon id for each item in the cart
        cartStore.addCouponToCartItem(null)
        toast.success("Coupon removed",{
            timeout: 2000
        })
    }

    //redirect the user to the home page if the cart is empty
    onMounted(() => {
        if(!cartStore.cartItems.length) {
            router.push('/')
        }
    })
</script>

<style scoped>
</style>