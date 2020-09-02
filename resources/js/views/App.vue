<template>
    <div class="full">
        <Navbar></Navbar>
        <div class="container mt-5">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
        <Footer></Footer>
    </div>
</template>
<script>
    import Navbar from "../components/Navbar";
    import Footer from "../components/Footer";
    export default {
        components: {Footer, Navbar},
        data(){
            return {
                isAuth: false
            }
        }
    }
</script>
<style>
    .full{
        height: 100%;
    }
</style>
