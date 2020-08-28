<template>
    <span>
        <template v-if="!edit">
            <h4 class="text-uppercase">Gör så här:
                <button class="btn btn-outline-secondary btn-sm" @click.prevent="showForm"><i class="fas fa-pencil-alt"></i></button></h4>
            <span v-html="how_to"></span>
        </template>
        <template v-if="edit">
            <button v-if="!loading" @click.prevent="save()" class="btn btn-primary">Spara</button>
            <button v-if="loading" class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
            <button class="btn btn-secondary">X</button>
            <editor
                v-model="form.newHowTo"
                api-key="5buum2l55appp07x4o90muhdvpfr51dqa0onbti5759pjlqu"
                :init="{
                    height: 300,
                    menubar: false,
                    plugis: [
                         'advlist autolink lists link image charmap print preview anchor',
                         'searchreplace visualblocks code fullscreen',
                         'insertdatetime media table paste code help wordcount',
                    ],
                    toolbar:
                         'undo redo | formatselect | bold italic backcolor | \
                          alignleft aligncenter alignright alignjustify | \
                          bullist numlist outdent indent | removeformat | help'
                }"
            />
        </template>
    </span>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue'
    import Form from 'vform'
    export default {
        name: "EditHowToComponent",
        components: {
            'editor': Editor
        },
        props: {
            recipe_id: '',
            how_to: {},
        },
        data() {
            return {
                edit: false,
                loading: false,
                form: new Form({
                    newHowTo: '',
                })
            }
        },
        methods: {
            showForm() {
                this.edit = true;
                this.form.newHowTo = this.how_to
            },
            save(){
                this.$Progress.start()
                this.loading = true;
                this.form.patch('api/recipes/'+this.recipe_id)
                    .then((data) =>{
                        console.log(data)
                        this.$Progress.finish()
                        this.loading = false
                        this.edit = false
                        this.how_to = this.form.newHowTo
                    })

            }
        }
    }
</script>

<style scoped>

</style>
