<template>
    <span>
        {{imageUrl}}
        <template><img  :src="url" @click="updateImage()" class="img-fluid"></template>
    </span>
</template>

<script>
    export default {
        name: "EditImageComponent",
        props: {
            recipe_id: ''
        },
        data(){
            return {
                url: 'https://assets.jawp.se/food.jpg'
            }
        },
        methods: {
        },
        computed: {
            imageUrl: function(){
                return 'https://assets.jawp.se/food.jpg'
            }
        }
    }
</script>

<style scoped>

</style>
