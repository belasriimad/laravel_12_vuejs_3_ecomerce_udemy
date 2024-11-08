<template>
  <div class="row">
    <div class="col-md-12">
        <button class="btn btn-dark btn-block"
            @click="fetchPaymentLink"
            >
            Proceed to payment
        </button>
    </div>
  </div>
</template>

<script setup>
    import axios from "axios"
    import { BASE_URL, headersConfig, makeUniqueId } from "../../helpers/config"
    import { useAuthStore } from "../../stores/useAuthStore"
    import { useCartStore } from "../../stores/useCartStore"

    //define the stores
    const authStore = useAuthStore()
    const cartStore = useCartStore()

    //define the unique hash 
    const hash = makeUniqueId(24)

    //get the payment link
    const fetchPaymentLink = async () => {
        try {
            const response = await axios.post(`${BASE_URL}/pay/order`,
                {
                    cartItems : cartStore.cartItems,
                    success_url: `http://localhost:5173/#/success/payment/${hash}`
                },
                headersConfig(authStore.access_token)
            )
            cartStore.setUniqueHash(hash)
            window.location.href = response.data.url
        } catch (error) {
            console.log(error)
        }
    }
</script>

<style scoped>
</style>