<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8">
                <EditTitleComponent :title="recipe.name" :duration="recipe.duration" :recipe_id="recipe.id" />
            </div>
            <div class="col-md-4 col-lg-4 col-sm-4 right">
                <DeleteRecipeComponent :recipe_id="recipe.id" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <template><img :src="url" height="600" width="1400" @click="updateImage()" class="img-fluid"></template>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <EditDescriptionComponent :id="recipe.id" :desc="recipe.desctiption" />
            </div>
        </div>
        <div class="border-top my-3"></div>
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <h4 class="text-uppercase">Ingredienser: <span><add-ingredient-component @update-ingredient="getIngredients(recipe.id)" :recipe_id="recipe.id"/></span></h4>
                <p v-for="ing in ingredients">
                    {{ing.amount}} {{ing.unit}} {{ing.name}}
                    <span>
                        <RemoveIngredientComponent :recipe_id="recipe.id" :ingredient_id="ing.id" @ingredient-removed="getIngredients(recipe.id)"/>
                    </span>
                </p>
            </div>
            <div class="col-md-6 col-lg-6">
                <EditHowToComponent :recipe_id="recipe.id" :how_to="recipe.how_to" />
            </div>
        </div>
        <div class="modal fade" id="ImageModal" tabindex="-1" role="dialog" aria-labelledby="newRecipeModal"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ImageLabel">Ändra bild</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form">
                            <div class="form-group">
                                <img :src="previewImage" class="uploading-image" />
                                <input type="file" required @change="setPreviewImage">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
                        <button v-if="!buttonLoading" type="submit" class="btn btn-primary" @click.prevent="uploadImage()">{{imageModalButtonText}}</button>
                        <button v-if="buttonLoading" class="btn btn-primary" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{imageModalButtonText}}
                        </button>
                        <template v-if="recipe.image">
                        <button  v-if="!deleteImageLoading" class="btn btn-danger" @click.prevent="deleteImage()">Ta bort bild</button>
                        <button v-if="deleteImageLoading" class="btn btn-danger" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AddIngredientComponent from "../../../components/admin/AddIngredientComponent";
    import RemoveIngredientComponent from "../../../components/admin/RemoveIngredientComponent";
    import {Form} from 'vform'
    import EditDescriptionComponent from "../../../components/admin/EditDescriptionComponent";
    import EditHowToComponent from "../../../components/admin/EditHowToComponent";
    import EditTitleComponent from "../../../components/admin/EditTitleComponent";
    import DeleteRecipeComponent from "../../../components/admin/DeleteRecipeComponent";
    export default {
        name: "ShowRecipe",
        components: {
            DeleteRecipeComponent,
            EditTitleComponent,
            EditHowToComponent, EditDescriptionComponent, RemoveIngredientComponent, AddIngredientComponent},
        data () {
            return {
                id: this.$route.params.id,
                url: process.env.MIX_ASSET_URL+process.env.MIX_BUCKET_FOLDER+'/food.jpg',
                recipe: {},
                ingredients: [],
                units: {},
                previewImage: null,
                image: null,
                imageModalButtonText: 'Spara bild',
                buttonLoading: false,
                deleteImageLoading: false
            }
        },
        created() {
            this.getRecipe(this.id)
        },
        methods: {
            async getRecipe(id) {
                axios.get('api/recipes/'+id)
                    .then(response => {
                        this.recipe = response.data
                        this.setImageUrl(this.id)
                        this.getIngredients(this.id)
                    })
                    .catch(error => {
                        if (error.response.status = 404) {
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
                                icon: 'error',
                                title: error.response.data.message
                            })
                            this.$router.push({name: '404'})
                        }
                    })
            },
            updateImage(){
                $('#ImageModal').modal('show')
            },
            setPreviewImage(e){
                const image = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    this.previewImage = e.target.result;
                    this.image = image
                    //console.log(this.image);
                };
            },
            uploadImage(){
                this.$Progress.start()
                this.buttonLoading = true;
              const formData = new FormData();
              formData.append('image', this.image, this.image.name);
                axios.post('/api/recipe/'+this.recipe.id+'/image', formData, {
                }).then((res) => {
                    //console.log(res)
                    this.url = process.env.MIX_ASSET_URL+'/'+res.data
                    this.recipe.image = res.data
                    this.buttonLoading = false;
                    this.$Progress.finish()
                    $('#ImageModal').modal('hide')
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
                        title: 'Bild sparad och uppladdad'
                    })
                })
            },
            async getIngredients(recipe){
                if(!this.ingredients.empty){
                    this.ingredients = []
                }
                const ingredients = await axios.get('api/ingredients/recipe/' + recipe)
                for (const [key, value] of Object.entries(ingredients.data.data)) {
                    const measurUnt = await axios.get('api/measurment-units/' + ingredients.data.data[key].measurment_unit_id)
                    ingredients.data.data[key].unit = measurUnt.data.data.name
                    this.ingredients.push(ingredients.data.data[key])
                }
            },
            async setImageUrl(recipe){
                const image = await axios.get('api/recipe/'+recipe+'/image')
                if(image.data){
                    this.url = this.assetUrl+image.data
                }
            },
            deleteImage(){
                this.$Progress.start()
                this.deleteImageLoading = true
                axios.delete('/api/recipe/'+this.recipe.id+'/image')
                    .then(response => {
                        this.url = process.env.MIX_ASSET_URL+process.env.MIX_BUCKET_FOLDER+'/food.jpg'
                        this.deleteImageLoading = false
                        this.recipe.image = null
                        this.$Progress.finish()
                        $('#ImageModal').modal('hide')
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
                            title: 'Bild borttagen'
                        })

                    })
            }
        },
        computed: {
            assetUrl: function () {
                return process.env.MIX_ASSET_URL
            }
        }
    }
</script>

<style scoped>
    img:hover {
        opacity: 0.2;
        cursor: grab;
    }
    .uploading-image{
        width: 100px;
        height: 100px;
    }
    .img-fluid{
        height: 400px;
        width: 1400px;
    }
</style>
