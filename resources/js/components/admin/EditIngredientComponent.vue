<template>
    <span>
        <button class="btn btn-outline-secondary btn-sm" @click.prevent="showEditModal"><i
            class="fas fa-pencil-alt"></i></button>
        {{ingredient_name}}
    </span>
</template>

<script>
    import {Form} from 'vform'

    export default {
        name: "EditIngredientComponent",
        props: {
            ingredient_name: '',
            recipe_id: ''
        },
        data() {
            return {
                form: new Form({
                    name: '',
                    amount: '',
                    measurment_unit: '',
                }),
                units: {}
            }
        },
        created() {
            axios.get('api/measurment-units')
                .then(response => {
                    this.units = response.data.data
                })
        },
        methods: {
            showEditModal() {
                $("#ingEdited").hide();
                $('#EditIngredientModal').modal('show')
            },
            updateIng(){
                this.$Progress.start()
                this.form.patch('api/ingredients/recipe/'+this.recipe_id+'/ingredient/'+this.ingredient_info.id)
                    .then((data) => {
                        this.form.name = ''
                        this.form.amount = ''
                        this.$emit('ingredient-edited')
                    })
                this.$Progress.finish()
                $('#EditIngredientModal').modal('show')
                $("#ingAddedd").fadeTo(2000, 500).slideUp(500, function() {
                    $("#ingAddedd").slideUp(500);
                });
            }
        }
    }
</script>

<style scoped>

</style>
