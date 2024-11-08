<template>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <router-link class="navbar-brand" to="/">
        <img
          src="https://cdn.pixabay.com/photo/2014/04/02/11/16/shopping-305728_1280.png"
          alt="Logo"
          width="60"
          height="60"
        />
      </router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link class="nav-link" aria-current="page" to="/">
              <i class="bi bi-house-door-fill"></i> Home
            </router-link>
          </li>
          <ul class="navbar-nav" v-if="!authStore.isLoggedIn">
            <li class="nav-item">
              <router-link
                class="nav-link"
                aria-current="page"
                to="/register"
              >
                <i class="bi bi-person-add"></i> Register
              </router-link>
            </li>
            <li class="nav-item">
              <router-link
                class="nav-link"
                aria-current="page"
                to="/login"
              >
                <i class="bi bi-box-arrow-right"></i> Login
              </router-link>
            </li>
          </ul>
          <ul class="navbar-nav" v-else>
            <li class="nav-item">
              <router-link
                class="nav-link"
                aria-current="page"
                to="/profile"
              >
                <i class="bi bi-person-check-fill"></i> {{ authStore.user.name }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link
                class="nav-link"
                @click="userLogout"
                aria-current="page"
                to="#"
              >
                <i class="bi bi-box-arrow-left"></i> Logout
              </router-link>
            </li>
          </ul>
          <li class="nav-item">
            <router-link
              class="nav-link"
              aria-current="page"
              to="/cart"
            >
              <i class="bi bi-cart-plus"></i> Cart ({{
                cartStore.cartItems.length
              }})
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link"
              aria-current="page"
              to="/favorites"
            >
              <i class="bi bi-heart-fill"></i> Favorites ({{
                favoritesStore.favorites.length
              }})
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
  import axios from "axios"
import { onMounted } from "vue"
  import { useRouter } from "vue-router"
  import { useToast } from "vue-toastification"
  import { BASE_URL, headersConfig } from "../../helpers/config"
  import { useAuthStore } from "../../stores/useAuthStore"
  import { useCartStore } from "../../stores/useCartStore"
  import { useFavoritesStore } from "../../stores/useFavoritesStore"

  //define the cart store
  const cartStore = useCartStore()
  const authStore = useAuthStore()
  const favoritesStore = useFavoritesStore()

  //define the toast 
  const toast = useToast()

  //define the router
  const router = useRouter()

  //logout function 
  const userLogout = async () => {
    try {
      const response = await axios.post(`${BASE_URL}/user/logout`,null,
        headersConfig(authStore.access_token))
        authStore.clearAuthData()
        toast.success(response.data.message,{
          timeout: 2000
        }) 
        router.push('/login')
    } catch (error) {
      console.log(error)
    }
  }

  //fetch the currently logged in user 
  //and check if the token is still valid
  const fetchCurrentUser = async () => {
    try {
      const response = await axios.get(`${BASE_URL}/user`,
        headersConfig(authStore.access_token))
        authStore.setIsLoggedIn()
        authStore.setUser(response.data.user)
        authStore.setToken(response.data.access_token)
    } catch (error) {
      if(error?.response?.status === 401) {
        authStore.clearAuthData()
      }
      console.log(error)
    }
  }

  //once the component is loaded we get the currently logged in user
  onMounted(() => authStore.isLoggedIn && fetchCurrentUser())
</script>

<style scoped>
  .navbar a {
    font-size: 1.1rem;
    font-weight: 700;
  }
</style>
