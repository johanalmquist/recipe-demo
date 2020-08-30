<template>
    <span>
        <button class="btn btn-outline-danger" @click.prevent="confirmDelete()"><i class="fas fa-trash-alt"></i></button>
    </span>
</template>

<script>
    export default {
        name: "DeleteRecipeComponent",
        props: ['recipe_id'],
        methods: {
            confirmDelete(){
                swal.fire({
                    title: 'Är du säker på att du vill tabort recpet?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ja, tabort!',
                    cancelButtonText: 'Avbryt'
                }).then((result) => {
                    if (result.value) {
                        swal.fire(
                            'Tar bort recpet',
                            'info'
                        )
                        this.delete()
                        // For more information about handling dismissals please visit
                        // https://sweetalert2.github.io/#handling-dismissals
                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        return null
                    }
                })
            },
            delete(){
                this.$Progress.start()
                axios.delete('api/recipes/'+this.recipe_id)
                    .then(response =>{
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
                            title: 'Recpetet är borttaget'
                        })
                        this.$router.push({name: 'admin'})
                    })
                    .catch(error => {

                    })
            }
        }
    }
</script>

<style scoped>

</style>
