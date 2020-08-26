<template>
    <span>
        <button @click.prevent="addIng()" class="btn btn-outline-secondary btn-sm"><i class="fas fa-plus"></i></button>
        <div class="modal fade" id="AddIngredientModal" tabindex="-1" role="dialog" aria-labelledby="newRecipeModal"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddIngredientLabel">Lägg till ingrediens</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="save()" class="form">
                            <div class="form-group">
                                <input type="text" class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('name') }" v-model="form.name"
                                       placeholder="Namn">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('amount') }" v-model="form.amount"
                                       placeholder="Mängd">
                                <has-error :form="form" field="amount"></has-error>
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model="form.measurment_unit" :class="{ 'is-invalid': form.errors.has('measurment_unit') }">
                                    <option v-for="unit in units" :key="unit.id" :value="unit.id">{{unit.name}}</option>
                                </select>
                                <has-error :form="form" field="measurment_unit"></has-error>
                            </div>
                        </form>
                        <div class="alert alert-success" id="ingAddedd">
                            Ingrediens är tillagd
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
                        <button type="button" class="btn btn-primary" @click.prevent="save()">Spara</button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
    import {Form} from 'vform'

    export default {
        name: "AddIngredientComponent",
        props: {
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
            addIng(e) {
                $("#ingAddedd").hide();
                $('#AddIngredientModal').modal('show')
            },
            save() {
                this.$Progress.start()
                this.form.post('api/ingredients/recipe/'+ this.recipe_id)
                    .then((data) => {
                        this.form.name = ''
                        this.form.amount = ''
                        this.$emit('update-ingredient')
                    })
                this.$Progress.finish()
                $("#ingAddedd").fadeTo(2000, 500).slideUp(500, function() {
                    $("#ingAddedd").slideUp(500);
                });

            }
        }
    }
</script>

<style scoped>

</style>
