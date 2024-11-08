import { defineStore } from 'pinia'
import axios from "axios"
import { BASE_URL, headersConfig } from "../helpers/config"
import { useAuthStore } from "../stores/useAuthStore"
import { useToast } from "vue-toastification"

//define the store 
const authStore = useAuthStore()

//define the toast
const toast = useToast()

export const useProductDetailsStore = defineStore('product', {
    state: () => ({ 
        product: null,
        productThumbnail: '',
        productImages: [],
        isLoading: false,
        errorMessage: '',
        reviewToUpdate: {
            updating: false,
            data: null
        }
    }),
    actions: {
        async fetchProduct(slug) {
            this.productImages = []
            this.isLoading = true
            try {
                const response = await axios.get(`${BASE_URL}/products/${slug}/show`)
                this.product = response.data.data 
                //get product thumbnail
                this.productThumbnail = response.data.data.thumbnail
                //add product images to the array
                if(response.data.data.first_image) {
                    this.productImages.push({
                        id: 1,
                        src: response.data.data.first_image
                    })
                }
                if(response.data.data.second_image) {
                    this.productImages.push({
                        id: 2,
                        src: response.data.data.second_image
                    })
                }
                if(response.data.data.third_image) {
                    this.productImages.push({
                        id: 3,
                        src: response.data.data.third_image
                    })
                }
                this.isLoading = false
            } catch (error) {
                this.isLoading = false
                console.log(error)
            }
        },
        editReview(review) {
            this.reviewToUpdate = {
                updating: true,
                data: review
            }
        },
        cancelUpdating() {
            this.reviewToUpdate = {
                updating: false,
                data: null
            }
        },
        async storeReview(review) {
            this.isLoading = true
            try {
                const response = await axios.post(`${BASE_URL}/store/review`, {
                    title : review.title,
                    body : review.body,
                    rating : review.rating,
                    product_id : this.product.id
                }, headersConfig(authStore.access_token))
                if(response.data.error) {
                    toast.error(response.data.error,{
                        timeout: 2000
                    })
                }else {
                    toast.success(response.data.message,{
                        timeout: 2000
                    })
                }
                this.isLoading = false
            } catch (error) {
                console.log(error)
                this.isLoading = false
            }
        },
        async removeReview(review) {
            if(confirm("are sure you want to delete this review ?")) {
                try {
                    const response = await axios.post(`${BASE_URL}/delete/review`, {
                        product_id : this.product.id
                    }, headersConfig(authStore.access_token))
                    if(response.data.error) {
                        toast.error(response.data.error,{
                            timeout: 2000
                        })
                    }else {
                        //remove the review from the product reviews array
                        this.product.reviews = this.product.reviews.filter(item => item.id !== review.id)
                        toast.success(response.data.message,{
                            timeout: 2000
                        })
                    }
                } catch (error) {
                    console.log(error)
                }
            }
        },
        async updateReview(review) {
            this.isLoading = true
            try {
                const response = await axios.put(`${BASE_URL}/update/review`, {
                    title : review.title,
                    body : review.body,
                    rating : review.rating,
                    product_id : this.product.id
                }, headersConfig(authStore.access_token))
                if(response.data.error) {
                    toast.error(response.data.error,{
                        timeout: 2000
                    })
                }else {
                    //remove the review from the product reviews array
                    this.product.reviews = this.product.reviews.filter(item => item.id !== review.id)
                    //set the review to update
                    this.reviewToUpdate = {
                        updating: false,
                        data: null
                    }
                    toast.success(response.data.message,{
                        timeout: 2000
                    })
                }
                this.isLoading = false
            } catch (error) {
                console.log(error)
                this.isLoading = false
            }
        }
    }
})