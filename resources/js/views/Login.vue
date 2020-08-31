<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Logga in</div>
                <div class="card-body">
                    <form class="form">
                        <div  v-if="hasError" class=" alert alert-danger">
                            {{errorMsg}}
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-post</label>
                            <div class="col-md-6">
                                <input id="email" type="email" v-model="email" class="form-control" required autocomplete="email" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Lösenord</label>
                            <div class="col-md-6">
                                <input id="password" type="password" v-model="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button v-if="!loading" type="submit" class="btn btn-primary" @click.prevent="login">
                                    Logga in
                                </button>
                                <button v-if="loading" class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data: function () {
            return {
                email: "",
                password: "",
                loading: false,
                hasError: false,
                errorMsg: null
            }
        },
        methods: {
            login(){
                this.loading = true
                this.$Progress.start()
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login', {
                        email: this.email,
                        password: this.password
                    }).then(response2 => {
                        sessionStorage.setItem("auth", true);
                        this.$Progress.finish()
                        this.loading = false
                        this.$router.push({name: 'admin'})
                    }).catch(error => {
                        this.loading = false
                        this.$Progress.fail()
                        this.hasError = true
                        this.errorMsg = error.response.data.message
                    })
                });
            }
        }
    }
</script>

<style scoped>

</style>
