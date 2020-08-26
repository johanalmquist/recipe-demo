<template>
    <div>
        <Navbar></Navbar>
        <div class="container mt-5">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
    </div>
</template>
<script>
    import Navbar from "../components/Navbar";
    export default {
        components: {Navbar},
    }
</script>
