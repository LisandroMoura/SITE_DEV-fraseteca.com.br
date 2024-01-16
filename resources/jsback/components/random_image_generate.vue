<template>    
    <div>
        <button 
        class="btn btn-success"
        @click.stop.prevent="$parent.imageCreate($parent.frase)" 
        >Gerar Randomicamente</button>
        
    </div> 
</template>

<script>    

    export default {     
        props: ['opcoes'], 
        
        data () {
            return {
                mostrar:false,
            }
        },
        mounted() {              
            this.opt = JSON.parse(this.opcoes)   
            //this.imgSrc = this.$refs.ref_imgSrc.src;         
        },
        methods:{   
                       
        }
    }
</script>

