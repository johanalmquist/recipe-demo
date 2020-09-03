<template>
    <span>
        <div class="row">
            <div class="col-md-10">
                <form>
                    <input type="text" placeholder="Sök.." v-model="query" @keyup.prevent="search()" class="form-control form-control-lg">
                </form>
            </div>
            <div class="col-md-2">
                <button class="btn btn-lg btn-primary"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <template v-if="loading">
            <div class="row justify-content-center mt-5">
                <SpinnerComponent/> &nbsp;
            </div>
        </template>
        <template v-if="noResult">
            <div class="row justify-content-center mt-5">
                <h2>Hittade inga recpet. Prova och sök igen</h2>
            </div>
        </template>
        <template v-if="result">
            <div class="row mt-5">
               <recipe-component :recipe="recipe" v-for="recipe in result" :key="recipe.id"></recipe-component>
            </div>
        </template>
    </span>
</template>

<script>
    import SpinnerComponent from "../components/SpinnerComponent";
    import RecipeComponent from "../components/RecipeComponent";
    export default {
        name: "Search",
        components: {RecipeComponent, SpinnerComponent},
        data(){
            return {
                result: null,
                noResult: false,
                loading: false,
                query: ''
            }
        },
        methods: {
            search() {
                this.loading = true
                axios.get('api/search/'+this.query)
                    .then(response => {
                        this.loading = false
                        if(response.status === 204){
                            this.result = false
                            this.loading = false
                            this.noResult = true
                        }
                        this.loading = false;
                        this.noResult = false
                        this.result = response.data
                        console.log(this.result)
                    })
            }
        }
    }
</script>

<style scoped>

</style>
