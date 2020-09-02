<template>
    <div>
        <spinner-component v-if="loading"></spinner-component>
        <div v-if="!loading">
            <div class="row">
                <div class="col-md-8 col-lg-8 col-sm-8">
                    <h1>{{recipe.name}} <span class="badge badge-secondary">{{recipe.duration}} minuter</span></h1>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-4">
                    <router-link to="/">Tillbaka till lista</router-link>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <img :src="url" class="img-fluid">
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
                        {{ing.amount}}
                        <measur-unit-component :id="ing.measurment_unit_id"></measur-unit-component>
                        {{ing.name}}
                    </p>
                </div>
                <div class="col-md-6 col-lg-6">
                    <h4 class="text-uppercase">Gör så här:</h4>
                    <span v-html="recipe.how_to"></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MeasurUnitComponent from "../components/MeasurUnitComponent";
    import SpinnerComponent from "../components/SpinnerComponent";

    export default {
        name: "Recipe",
        components: {SpinnerComponent, MeasurUnitComponent},
        data: function () {
            return {
                id: this.$route.params.id,
                recipe: [],
                ingredients: {},
                name: "",
                url: null,
                time: 0,
                loading: true
            }
        },
        methods: {
            getRecipe(id) {
                axios.get('api/recipes/' + id)
                    .then(response => {
                        this.recipe = response.data
                        this.setImageUrl()
                        this.setdurationTime()
                        this.getingredients(this.id)
                        this.loading = false
                    })
                    .catch(error => {
                        if (error.response.status = 404) {
                            const Toast = swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                onOpen: (toast) => {
                                    toast.addEventListener('mouseenter', swal.stopTimer)
                                    toast.addEventListener('mouseleave', swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: error.response.data.message
                            })
                            this.$router.push({name: '404'})
                        }
                    })
            },
            getingredients(recipe) {
                axios.get('api/ingredients/recipe/' + recipe)
                    .then(response => {
                        this.ingredients = response.data.data
                    })
            },
            setImageUrl() {
                if (this.recipe.image === null) {
                    this.url = process.env.MIX_ASSET_URL + process.env.MIX_BUCKET_FOLDER + '/food.jpg'
                } else {
                    this.url = process.env.MIX_ASSET_URL + this.recipe.image
                }
            },
            setdurationTime() {
                this.time = this.recipe.duration
            },
        },
        mounted() {
            this.getRecipe(this.id)
        },
    }
</script>

<style scoped>
    .img-fluid {
        height: 400px;
        width: 1400px;
    }
</style>
