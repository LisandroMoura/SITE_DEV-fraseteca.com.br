<template>    
    <div class="modalbox">

        MODALBOX

    </div>    
</template>

<script>    
    export default {     
        props: ['opcoes'],   
        data () {
            return {                
                files: [],
                names: [],
                images: [],
            }
        },
        mounted() {                              
        },
        methods:{
        }
    }
</script>

<style lang="scss" scoped>
    .modalbox {
        width: 100%;        
    }
</style>
