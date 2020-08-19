<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="float-right">
                    <button class="btn btn-success" @click="showModal()">Nytt Recpet</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Namn</th>
                            <th>Skapad</th>
                            <th>Senast ändrad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="recipe in recipes.data" :key="recipe.id">
                            <td>{{recipe.name}}</td>
                            <td>{{recipe.created_at}}</td>
                            <td>{{recipe.updated_at}}</td>
                        </tr>
                    </tbody>
                </table>
                <pagination :data="recipes" @pagination-change-page="getRecipes"></pagination>
            </div>
        </div>

        <div class="modal fade" id="newRecipeModal" tabindex="-1" role="dialog" aria-labelledby="newRecipeModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newRecipeModalLabel">Nytt recpet</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="createRecipe()">
                            <input type="text" class="form-control" v-model="form.name" placeholder="Namn på recept">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click.prevent="createRecipe()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {Form} from 'vform'
    export default {
        name: "Admin",
        data () {
            return {
                recipes: {},
                form: new Form({
                    name: '',
                    duration: '0'
                })
            }
        },
        methods: {
            async getRecipes(page = 1){
                const respose = await axios.get('api/recipes?page='+ page);
                this.recipes = respose.data
            },
            showModal(){
                $('#newRecipeModal').modal('show')
            },
            createRecipe(){
                this.form.post('/api/recipes')
                    .then((data) => {console.log(data)})
                //$('#newRecipeModal').modal('hide')
            }
        },
        created() {
            this.getRecipes()
        }
    }
</script>

<style scoped>

</style>
