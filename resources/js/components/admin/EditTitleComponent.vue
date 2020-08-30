<template>
    <span>
        <h1>
            <span><button class="btn btn-outline-secondary btn-sm" @click.prevent="showEditModal()"><i class="fas fa-pencil-alt"></i></button></span>
            {{title}} <span class="badge badge-secondary">{{duration}} minuter</span>
        </h1>


        <div class="modal fade" id="EditTitleModal" tabindex="-1" role="dialog" aria-labelledby="newRecipeModal"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditTitleLabel">Ändra namn och tillagningstid</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="save()" class="form">
                            <div class="form-group">
                                <label>Namn</label>
                                <input type="text" class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('name') }" v-model="form.name"
                                       placeholder="Namn">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Tillagningstid</label>
                                <input type="tel" class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('duration') }" v-model="form.duration"
                                       placeholder="">
                                <has-error :form="form" field="duration"></has-error>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
                        <button v-if="!loading" type="button" class="btn btn-primary" @click.prevent="save()">Spara</button>
                        <button v-if="loading" class="btn btn-primary" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </span>
</template>

<script>
    import Form from 'vform'
    export default {
        name: "EditTitleComponent",
        props: ['title', 'duration', 'recipe_id'],
        data() {
            return {
                loading: false,
                form: new Form({
                    name: null,
                    duration: null
                })
            }
        },
        methods: {
            showEditModal(){
                this.form.name = this.title
                this.form.duration = this.duration
                $("#titleUppded").hide();
                $('#EditTitleModal').modal('show')
            },
            save(){
                this.loading = true
                this.$Progress.start()
                this.form.patch('api/recipes/'+this.recipe_id)
                    .then((data) => {
                        this.$Progress.finish()
                        this.loading = false
                        $('#EditTitleModal').modal('hide')
                        this.title = this.form.name
                        this.duration = this.form.duration
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
                            title: 'Uppdaterat'
                        })
                    })
                    .catch((error) => {
                        this.loading = false
                        this.$Progress.fail()
                    })
            }
        }
    }
</script>

<style scoped>

</style>
