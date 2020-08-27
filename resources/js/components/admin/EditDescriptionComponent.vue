<template>
    <span>
        <h3>
            <small class="text-muted" v-if="!edit">{{desc}}</small>
            <template v-if="edit">
                <form class="form">
                    <textarea class="form-control" v-model="form.desctiption"></textarea>
                    <button v-if="!loading" class="btn btn-primary btn-sm" @click.prevent="save()">Spara</button>
                    <button v-if="loading" class="btn btn-primary btn-sm" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>
                    <button class="btn btn-secondary btn-sm" @click.prevent="editForm()">X</button>
                </form>
            </template>
            <template v-if="!edit">
                <button v-if="!desc" class="btn btn-outline-secondary btn-sm" @click.prevent="editForm()">Lägg till beskrvning</button>
                <button v-if="desc" class="btn btn-outline-secondary btn-sm" @click.prevent="editForm()"><i class="fas fa-pencil-alt"></i></button>
            </template>
        </h3>
    </span>
</template>

<script>
    import Form from 'vform'
    export default {
        name: "EditDescriptionComponent",
        props: {
            id: '',
            desc: null,
        },
        data() {
            return {
                edit: false,
                loading: false,
                form: new Form({
                    desctiption: null
                })
            }
        },
        methods: {
            save(){
                this.$Progress.start()
                this.loading = true
                this.form.patch('api/recipes/'+this.id)
                    .then((data) => {
                        console.log(data)
                        this.$Progress.finish()
                        this.loading = false
                        this.edit = false;
                        this.desc = this.form.desctiption
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
                            title: 'Beskrvning är uppdaterad'
                        })
                    })
                    .catch((data) => {
                        this.$Progress.fail()
                        this.loading = false
                    })

            },
            editForm() {
                this.edit = !this.edit
                this.form.desctiption = this.desc
            }
        },
    }
</script>

<style scoped>

</style>
