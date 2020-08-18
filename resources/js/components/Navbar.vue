<template>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #3CB371;">
        <a class="navbar-brand" href="#">Recept</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse left" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'home' }">Hem</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'login' }">Logga in</router-link>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="logout">Logga ut</a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",
        methods: {
            logout(){
                axios.post('logout')
                    .then(res => {
                        localStorage.removeItem('isLoggedIn');
                        this.$router.push({name: 'login'})
                    })
            }
        }
    }
</script>

<style scoped>

</style>
