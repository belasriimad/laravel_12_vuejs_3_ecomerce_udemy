<template>
   <div class="row m-3">
    <div class="col-md-8 mx-auto">
        <ul class="list-group my-2" v-for="(validationErrors,index) in formValidationErrors"
            :key="index">
            <li class="list-group-item bg-danger text-white mb-1 rounded-0"
                v-for="(error,index) in validationErrors"
                :key="index"
                >
                {{ error }}
            </li>
        </ul>
    </div>
   </div>
</template>

<script setup>
    //define the props
    const props = defineProps({
        formValidationErrors: {
            type: Object,
            required: false,
            default: null
        }
    })
</script>

<style scoped>
</style>