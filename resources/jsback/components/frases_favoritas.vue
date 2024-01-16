<template>    
 <div class="row">
    <div class="col container-corpo">
        <div class="corpo-das-frases">
            <div class="frase-box"
                v-for="(dado, index) in this.$parent.listasFrasesPai" :key="index">
                <span :id="`frase_${index}`">{{dado.frase}}</span>
                <div class="autor">{{dado.autor}}</div>
                <div class="barra-botoes">
                    <ul>
                         <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="deletaFraseFavorita(dado.id, index)"
                            class="icon-trash-1"
                            :title="`Não quero mais isso. Deleta vai? ${dado.id}`"
                            ></a>
                        </li>
                        <span class="divisor"></span>
                        <li>
                            <a href="#Frase"
                            v-on:click.stop.prevent="copiarFraseFavorita(dado.frase)"
                            class="icon icone icon-files-o"
                            title="Copiar"
                            style="padding: 5px 8px;"
                            ></a>
                        </li>
                       
                    </ul>                    
                </div>
                <ul class="marcacao">
                    <li>
                        <a href="">
                            {{dado.marcacao}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
 </div>    
</template>
<script>    
    // import '../../../public/fonts/css/fontello.css';
    export default {     
        props: ['propdados','opcoes'],   
        data () {
            return { 
                dados_favoritas :[], 
                opt:[],  
                coluna:"col-lg-12"             
            }
        },
        mounted() {
            this.opt                     = JSON.parse(this.opcoes) ;
            this.coluna                  = this.opt.coluna;
            this.$parent.listasFrasesPai = JSON.parse(this.propdados);                          
        },
        watch:{        
        },
        methods:{
            deletaFraseFavorita(id, index){
                let url;               
                const formData = new FormData();              
                formData.append('id',id);    

                url = `/frasesfavoritas/${id}`;          
                axios.delete(url)
                .then(respo => {                      
                    if(respo.data.deleted){
                        this.$parent.listasFrasesPai.splice(index, 1);
                        this.$toastr.s(`Sucesso! \n\r Frase favorita deletada`);
                    }                
                    else{
                        this.$toastr.e(`${respo.data.titulo_msg} ${respo.data.msg}`);              
                    }
                })
           },
           copiarFraseFavorita(frase){
               //colocar na área de transfrência todo o conteúdo copiado
               var tempInput = document.createElement("input"); 
                
                //tempInput.setAttribute('type', 'hidden');
                document.body.appendChild(tempInput);
                tempInput.value = frase;                
                tempInput.select();               
                try {                    
                    var successful = document.execCommand('copy');                    
                    alert('Frase copiada com sucesso! ');
                    document.body.removeChild(tempInput);              
                } catch (err) {
                    alert('Oops, não foi possível copiar.');
                }

           },

        },
        
    }
    
</script>

<style lang="scss">    
    @import '../../sass/pages/favoritas.scss' ; 
</style>
