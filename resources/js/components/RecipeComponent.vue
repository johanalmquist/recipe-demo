<template>
    <div class="card col-md-5 col-lg-4 mt-3">
        <img class="card-img-top" src="https://via.placeholder.com/100x70" alt="Card image cap">
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
        data: function () {
            return {

            }
        },
    }
</script>

<style scoped>

</style>
