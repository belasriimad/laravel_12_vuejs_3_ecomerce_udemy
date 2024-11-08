<template>
  <div class="row mt-4">
    <div class="col-md-8 mx-auto">
        <div :class="`alert alert-${bgColor} d-flex align-items-center`">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <div>
                {{ content }}
            </div>
        </div>
    </div>
  </div>
</template>

<script setup>
    //define the props
    const props = defineProps({
        bgColor: {
            type: String,
            required: true
        },
        content: {
            type: String,
            required: true
        }
    })
</script>

<style scoped>
</style>