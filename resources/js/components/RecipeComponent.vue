<template>
    <div class="card col-md-5 col-lg-4 mt-3">
        <img class="card-img-top" :src="url" width="300" height="200" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">{{recipe.name}}</h5>
            <span class="badge badge-pill badge-dark">{{recipe.duration}} minuter</span>
            <p class="card-text">{{recipe.desctiption}}</p>
            <router-link :to="'/recipe/' + recipe.id" class="btn btn-primary">Visa recpet</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RecipeComponent",
        props: ['recipe'],
        data () {
            return {
                url: null
            }
        },
        mounted() {
            this.setImagrUrl()
        },
        methods: {
            setImagrUrl() {
                if(this.recipe.image === null){
                    this.url = process.env.MIX_ASSET_URL+process.env.MIX_BUCKET_FOLDER+'/food.jpg'
                } else {
                    this.url = process.env.MIX_ASSET_URL+this.recipe.image
                }
            }
        },
        computed: {
            imageUrl: function () {
                return process.env.MIX_ASSET_URL+this.recipe.image
            }
        }
    }
</script>

<style scoped>

</style>
