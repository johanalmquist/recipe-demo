<template>
    <span>
        <button v-if="!loading" class="btn btn-outline-danger btn-sm" @click.prevent="remove()"><i
            class="fas fa-minus"></i></button>
        <button v-if="loading" class="btn btn-outline-danger" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
    </span>
</template>

<script>
    export default {
        name: "RemoveIngredientComponent",
        props: {
            recipe_id: '',
            ingredient_id: ''
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            remove() {
                this.$Progress.start()
                this.loading = true
                axios.delete('api/ingredients/recipe/' + this.recipe_id + '/ingredient/' + this.ingredient_id)
                    .then(reponse => {
                        this.$emit('ingredient-removed', '')
                        this.$Progress.finish()
                        this.loading = false
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
                            title: 'Ingrediens är bortagen'
                        })
                    })
            }
        }
    }
</script>

<style scoped>

</style>
