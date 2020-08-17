<template>
    <div>
        <div class="row">
            <div class="card col-md-5 col-lg-4 mt-3" v-for="recipe in recipes.data" :key="recipe.id">
                <img class="card-img-top" src="https://via.placeholder.com/100x70" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{recipe.name}}</h5>
                    <span class="badge badge-pill badge-dark">{{recipe.duration}} minuter</span>
                    <p class="card-text">{{recipe.desctiption}}</p>
                    <a href="#" class="btn btn-primary">Visa recpet</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Recipe",
        data: function () {
            return {
                recipes: [],
                feating: true
            }
        },
        mounted() {
            axios.get('api/recipes')
                .then(response => {
                    this.recipes = response.data
                });
            this.feating = !this.feating;
        },
        methods: {
            getRecipes(){

            }
        },
    }
</script>

<style scoped>

</style>
