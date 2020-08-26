<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8">
                <h1>{{recipe.name}} <span><button class="btn btn-outline-secondary btn-sm"><i class="fas fa-pencil-alt"></i></button></span></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <img src="https://via.placeholder.com/1400x600" @click="updateImage()" class="img-fluid">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <h3>
                    <small class="text-muted">{{recipe.desctiption}}</small>
                    <button v-if="!recipe.desctiption" class="btn btn-outline-secondary btn-sm">Lägg till beskrvning</button>
                    <button v-if="recipe.desctiption" class="btn btn-outline-secondary btn-sm"><i class="fas fa-pencil-alt"></i></button>
                </h3>
            </div>
        </div>
        <div class="border-top my-3"></div>
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <h4 class="text-uppercase">Ingredienser: <span><add-ingredient-component @update-ingredient="getIngredients(recipe.id)" :recipe_id="recipe.id"/></span></h4>
                <p v-for="ing in ingredients">
                    {{ing.amount}} {{ing.unit}} {{ing.name}}
                    <span>
                        <RemoveIngredientComponent :recipe_id="recipe.id" :ingredient_id="ing.id" @ingredient-removed="getIngredients(recipe.id)"/>
                    </span>
                </p>
            </div>
            <div class="col-md-6 col-lg-6">
                <h4 class="text-uppercase">Gör så här: <button class="btn btn-outline-secondary btn-sm"><i class="fas fa-pencil-alt"></i></button></h4>
                {{recipe.how_to}}
            </div>
        </div>
    </div>
</template>

<script>
    import AddIngredientComponent from "../../../components/admin/AddIngredientComponent";
    import RemoveIngredientComponent from "../../../components/admin/RemoveIngredientComponent";
    export default {
        name: "ShowRecipe",
        components: {RemoveIngredientComponent, AddIngredientComponent},
        data () {
            return {
                id: this.$route.params.id,
                recipe: {},
                ingredients: [],
                units: {},
            }
        },
        created() {
            this.getRecipe(this.id)
            this.getIngredients(this.id)
        },
        methods: {
            async getRecipe(id) {
                const recipe = await axios.get('api/recipes/' + id)
                this.recipe = recipe.data
            },
            updateImage(){
            },
            async getIngredients(recipe){
                if(!this.ingredients.empty){
                    this.ingredients = []
                }
                const ingredients = await axios.get('api/ingredients/recipe/' + recipe)
                for (const [key, value] of Object.entries(ingredients.data.data)) {
                    const measurUnt = await axios.get('api/measurment-units/' + ingredients.data.data[key].measurment_unit_id)
                    ingredients.data.data[key].unit = measurUnt.data.data.name
                    this.ingredients.push(ingredients.data.data[key])
                }
            }


        }
    }
</script>

<style scoped>
    img:hover {
        opacity: 0.2;
        cursor: grab;
    }
</style>
