<template>
  <div class="row my-5">
    <ProfileSidebar />
    <UpdateUserInfos :updatingProfile="true" />
  </div>
</template>

<script setup>
    import ProfileSidebar from "./ProfileSidebar.vue"
    import UpdateUserInfos from "./UpdateUserInfos.vue"
</script>

<style scoped>
</style>