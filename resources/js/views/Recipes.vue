<template>
    <div>
        <div v-if="loading" class="my-auto mx-auto">
            <spinner-component></spinner-component>
        </div>
        <div class="row">
                <recipe-component :recipe="recipe" v-for="recipe in recipes.data" :key="recipe.id"></recipe-component>
        </div>
        <pagination :data="recipes" @pagination-change-page="getRecipes"></pagination>
    </div>
</template>

<script>
    import SpinnerComponent from "../components/SpinnerComponent";
    import RecipeComponent from "../components/RecipeComponent";
    export default {
        name: "Recipes",
        components: {SpinnerComponent, RecipeComponent},
        data: function () {
            return {
                recipes: {},
                loading: true
            }
        },
        mounted() {
            this.getRecipes()
        },
        methods: {
            getRecipes(page = 1){
                axios.get('api/recipes?page='+ page)
                    .then(response => {
                        this.recipes = response.data
                        this.loading = !this.loading
                    });
            }
        },
    }
</script>

<style scoped>

</style>
