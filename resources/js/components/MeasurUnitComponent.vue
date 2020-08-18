<template>
    <span>{{this.name}}</span>
</template>

<script>
    export default {
        name: "MeasurUnitComponent",
        props: ['id'],
        data: function () {
            return {
                name: ""
            }
        },
        methods: {
            getUnitName(id){
                axios.get('http://recept.test/api/measurment-units/' + id)
                    .then(response => {
                        this.name = response.data.data.name
                    })
            }
        },
        created(){
            this.getUnitName(this.id)
        }
    }
</script>

<style scoped>

</style>
