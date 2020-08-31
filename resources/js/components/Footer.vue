<template>
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">&copy; Johan Almquist</div>
                <div class="col-md-4">
                    API version: 1.0
                    Client version: 1.0
                </div>
                <div class="col-md-4"><a href="/admin">Admin</a></div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Footer"
    }
</script>

<style scoped>
    footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 30px; /* Set the fixed height of the footer here */
        line-height: 30px; /* Vertically center the text there */
        background-color: #2a9055;
        color: #ffffff;
    }
    a{
        color: #ffffff;
    }
    a:hover{
        text-decoration: underline;
    }
</style>
