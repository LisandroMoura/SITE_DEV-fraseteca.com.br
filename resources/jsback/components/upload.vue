<template>
    <div class="container">
        <image-uploader :opcoes="this.opcoes"></image-uploader>
    </div>
</template>

<script>
    import ImageUploader from  './imageUploader' 
    
    export default {
        props: ['opcoes'],
        data () {
            return {  
                 tipoTxt:'',                  
            }
        },
        mounted() {             
        },
        components:{
            ImageUploader
        }
    }
</script>

<style lang="scss" >
    @import '~vue-toastr/src/vue-toastr.scss' ; 
</style

