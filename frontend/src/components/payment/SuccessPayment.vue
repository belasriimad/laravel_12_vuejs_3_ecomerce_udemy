<template>
    <div class="row my-5">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-body p-5">
                    <h4 class="text-center">
                        Payment is done successfully
                    </h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import axios from "axios"
    import { onMounted } from "vue"
    import { useRoute, useRouter } from "vue-router"
    import { useToast } from "vue-toastification"
    import { BASE_URL, headersConfig } from "../../helpers/config"
    import { useAuthStore } from "../../stores/useAuthStore"
    import { useCartStore } from "../../stores/useCartStore"

    //define the stores
    const authStore = useAuthStore()
    const cartStore = useCartStore()

    //define the toast
    const toast = useToast()

    //define the toast
    const route = useRoute()
    const router = useRouter()

    //store user orders
    const storeUserOrders = async () => {
        try {
            const response = await axios.post(`${BASE_URL}/store/order`,
                {
                    cartItems : cartStore.cartItems,
                },
                headersConfig(authStore.access_token)
            )
            cartStore.clearCartItems()
            cartStore.setValidCoupon({
                name: '',
                discount: 0
            })
            authStore.user = response.data.user
            toast.success("Check your orders status in your profile tab",{
                timeout: 2000
            })
        } catch (error) {
            console.log(error)
        }
    }

    //once the component is mounted we store user orders
    onMounted(() => {
        if(cartStore.uniqueHash === route.params.hash) {
            storeUserOrders()
            cartStore.setUniqueHash('')
        }else {
            router.push('/')
        }
    })

</script>

<style scoped>
</style>