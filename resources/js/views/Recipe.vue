<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8">
                <h1>{{recipe.name}}</h1>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-4">
                <router-link to="/">Tillbaka till lista</router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <img src="https://via.placeholder.com/1400x600" class="img-fluid">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <h3>
                    <small class="text-muted">{{recipe.desctiption}}</small>
                </h3>
            </div>
        </div>
        <div class="border-top my-3"></div>
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <h4 class="text-uppercase">Ingredienser:</h4>
                <p v-for="ing in ingredients" :key="ing.id">
                    {{ing.amount}} <measur-unit-component :id="ing.measurment_unit_id"></measur-unit-component> {{ing.name}}
                </p>
            </div>
            <div class="col-md-6 col-lg-6">
                <h4 class="text-uppercase">Gör så här:</h4>
                {{recipe.how_to}}
            </div>
        </div>
    </div>
</template>

<script>
    import MeasurUnitComponent from "../components/MeasurUnitComponent";
    export default {
        name: "Recipe",
        components: {MeasurUnitComponent},
        data: function () {
            return {
                id: this.$route.params.id,
                recipe: [],
                ingredients: {},
                name: "",
                loading: true
            }
        },
        methods: {
            getRecipe(id) {
                axios.get('api/recipes/' + id)
                    .then(response => {
                        this.recipe = response.data
                    });
            },
            getingredients(recipe){
                axios.get('api/ingredients/recipe/' + recipe)
                    .then(response => {
                        this.ingredients = response.data.data
                    })
            },
        },
        created() {
            this.getRecipe(this.id)
            this.getingredients(this.id)
        },
        computed: {
            measurUnit(){
                return "Hello!"
            }
        }
    }
</script>

<style scoped>

</style>
