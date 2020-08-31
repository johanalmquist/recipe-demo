<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="float-right">
                    <button class="btn btn-success" @click.prevent="showModal()">Nytt Recpet</button>
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
                            <td><router-link :to="{name: 'admin.recipe', params: {id : recipe.id}}">{{recipe.name}}</router-link></td>
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
                            <div class="form-group">
                                <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" v-model="form.name" placeholder="Namn på recept">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-if="!loading" type="button" class="btn btn-primary" @click.prevent="createRecipe()">Save changes</button>
                        <button v-if="loading" class="btn btn-primary" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
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
                loading: false,
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
                this.$Progress.start()
                this.loading = true;
                this.form.post('/api/recipes')
                    .then((data) => {
                        this.loading = false;
                        $('#newRecipeModal').modal('hide')
                        this.$Progress.finish()
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
                            icon: 'success',
                            title: 'Nytt recepet är skapat'
                        })
                        this.$router.push({ name: 'admin.recipe', params: { id: data.data.id } })
                    })

                this.form.name = ''
            }
        },
        created() {
            this.getRecipes()
        }
    }
</script>

<style scoped>

</style>
