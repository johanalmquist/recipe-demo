<template>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #3CB371;">
        <a class="navbar-brand" href="#">{{appName}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse left" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'home' }">Hem</router-link>
                </li>
                <li class="nav-item float-right">
                    <router-link class="nav-link" v-if="!this.$isAuth" :to="{ name: 'login' }">Logga in</router-link>
                </li>
                <li class="nav-item" v-if="this.$isAuth">
                    <a href="#" class="nav-link" @click.prevent="logout">Logga ut</a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",
        data () {
            return {
            }
        },
        methods: {
            logout(){
                this.$Progress.start()
                axios.post('logout')
                    .then(res => {
                        sessionStorage.setItem("auth", false);
                        this.$Progress.finish()
                        this.$router.push({name: 'login'})
                        this.$isAuth = false
                    })
            },
            isLoggedIn(){
                if(localStorage.getItem('isLoggedIn')){
                    return this.auth = true
                }
                return this.auth = false

            }
        },
        created(){
        },
        computed: {
            appName: function () {
                return process.env.MIX_APP_NAME
            }
        }
    }
</script>

<style scoped>

</style>
