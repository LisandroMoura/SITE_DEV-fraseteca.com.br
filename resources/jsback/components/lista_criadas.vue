<template>    
 <div class="row">
    <div class="col">
        <ul class="ul-dados thumbnail">    
            <li class="col-lg-4" v-for="(dado, index) in this.$parent.listasCriadasPai" :key="index">                
                <a v-if="dado.thumb" :href="`/${dado.urlamigavel}`" class="link-imagem col-lg-7" :title="`${dado.titulo}`"
                    :style="`width: 187px;height: 151px; background-image: url(${dado.thumb});`"
                    >
                </a>
                <a v-else :href="`/${dado.urlamigavel}`" class="link-imagem col-lg-7" :title="`${dado.titulo}`"
                    :style="`width: 187px;height: 151px; background-image: url(${dado.capa});`"
                    >
                </a>   
                
                <div class="texto col-lg-5">
                    <div class="table">
                        <div class="table-cell">
                            <a :href="`/${dado.urlamigavel}`" :title="`${dado.titulo}`">
                                {{dado.titulo}}
                            </a>
                        </div>
                    </div>                
                </div>
            </li>
        </ul>
    </div>
 </div>    
</template>
<script>    
    export default {     
        props: ['propdados'],   
        data () {
            return { 
                
            }
        },
        mounted() { 
            this.$parent.listasCriadasPai = JSON.parse(this.propdados)  ;              
        },
        watch:{        
        },        
    }
</script>