<template>
  <div class="container">
    <Navbar />
    <router-view></router-view>
  </div>
</template>

<script setup>
  import Navbar from "./components/layouts/Navbar.vue"
</script>

<style scoped>
</style>
