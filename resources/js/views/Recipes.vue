<template>
    <div>
        <div class="row">
                <recipe-component :recipe="recipe" v-for="recipe in recipes.data" :key="recipe.id"></recipe-component>
        </div>
        <pagination :data="recipes" @pagination-change-page="getRecipes"></pagination>
    </div>
</template>

<script>
    import RecipeComponent from "../components/RecipeComponent";
    export default {
        name: "Recipes",
        components: {RecipeComponent},
        data: function () {
            return {
                recipes: {},
                feating: true
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
                    });
            }
        },
    }
</script>

<style scoped>

</style>
