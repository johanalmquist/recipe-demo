<template>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #3CB371;">
        <a class="navbar-brand" href="/">{{appName}}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",
        props: ['isAuth'],
        data () {
            return {
            }
        },
        methods: {
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
