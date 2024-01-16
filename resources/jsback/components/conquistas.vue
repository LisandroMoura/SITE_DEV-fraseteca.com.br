<template>    
    <div>        
        <div class="nuven-deconquista"> 
            <h5>Atribuidas para o usuário:</h5>
            <div class="caixaconquista caixatag">                
                <ul class="item-nuvem">
                    <li class="item-conquista" data=""
                        v-for="(conquista, index) in conquistasDoUserAux"
                                v-bind:key="conquista.id"
                                v-bind:index="conquista.id"
                                v-bind:title="conquista.descricao"   
                                v-on:click.stop.prevent="removeConquistaNoUser(index,conquista)"
                        >
                        {{mostraConquista(conquista)}}
                        <span class="fechar">
                            <i class="ico ico-sair ico-exit"></i>
                        </span>
                    </li>
                </ul>                                    
                <!-- <div class="row">
                    <div class="col">
                        <input 
                        v-model.lazy="txtInserir" 
                        type="text" 
                        class="txt_inserir_nova"
                        placeholder="inserir nova conquista,">                        
                        <button class="txt_inserir_nova_button"
                        v-on:click.stop.prevent="inserirNovaConquista"                        
                        >Inserir</button>
                        <input 
                        v-model.lazy="txtConquistasNovas" 
                        id="txtConquistasNovas"
                        name="txtConquistasNovas"
                        type="hidden"                         
                        >
                    </div>
                </div> -->

                <div class="caixaconquista caixatag adcionar">
                       <h5>Conquistas disponíveis no sistema:</h5> 
                    <ul class="item-nuvem">                       
                        <li class="item-conquista" data=""
                            v-for="(conquista, index) in bancoDeconquistasAux"
                            v-bind:key="conquista.id"
                            v-bind:index="conquista.id"
                            v-bind:title="conquista.descricao"
                            v-on:click.stop.prevent="addConquistaNoUser(index,conquista)"
                            > 
                            {{mostraConquista(conquista)}}
                            <span class="fechar">
                                <i class="ico ico-sair ico-exit"></i>
                            </span>
                        </li>                       
                    </ul>
                </div>
                
            </div>                     
        </div>      
    </div>     
</template>

<script>    
    export default {     
        props: ['opcoes','listaconquistas','conquistadados'],   
        data () {
            return { 
                conquistasDoUser:[],
                conquistasDoUserAux:[],
                bancoDeconquistas:[], 
                bancoDeconquistasAux:[], 
                opt:[],                
                txtInserir:'',
                conquistasNovas:[],
                txtConquistasNovas:"",
            }
        },
        mounted() {              
            this.opt                    = JSON.parse(this.opcoes)               
            this.conquistasDoUser       = JSON.parse(this.listaconquistas);
            this.atualizaConquista();            
            this.bancoDeconquistas      = JSON.parse(this.conquistadados);
            this.atualizaBanco();
            this.atualizaCampoConquista();

            
        },
        methods:{
            inserirNovaConquista(){
                let arrTxtInserir =this.txtInserir.split(",");
                arrTxtInserir.forEach(ele =>{   
                    if(!this.bancoDeconquistasAux.includes(ele) && 
                       !this.conquistasDoUserAux.includes(ele) &&
                       !this.conquistasNovas.includes(ele))                    
                        this.conquistasDoUserAux.push(ele);                    
                        this.conquistasNovas.push(ele);                        
                });
                this.txtInserir="";
                this.txtConquistasNovas="";
                this.conquistasNovas.forEach(ele => {
                    this.txtConquistasNovas += ele + ','; 
                });
                this.atualizaCampoConquista();
            },
            addConquistaNoUser(index,conquista){ 
                self= this;
                let id = 0;
                this.bancoDeconquistasAux.forEach(element => {                                        
                    if(element==conquista) {                        
                        this.conquistasDoUserAux.push(conquista);
                        this.bancoDeconquistasAux.splice(id,1);                        
                    }
                    id++;
                });
                this.atualizaCampoConquista();
            },
            removeConquistaNoUser(index,conquista){
                self = this;
                let id = 0;
                this.conquistasDoUserAux.forEach(element => {                                        
                    if(element==conquista) {
                        this.bancoDeconquistasAux.push(conquista);
                        this.conquistasDoUserAux.splice(id,1);
                    }
                    id++;
                });
                this.atualizaCampoConquista();
            },
            atualizaConquista(){                
                this.conquistasDoUserAux=[];
                 for (let elem in this.conquistasDoUser) { 
                    this.conquistasDoUserAux.push(elem + "#" + this.conquistasDoUser[elem]);                                                        
                }
            },
            atualizaCampoConquista(){
                var pai = this.$parent;                
                pai.conquistas= "";
                this.conquistasDoUserAux.forEach(ele=> {                    
                    pai.conquistas += ele+',';
                });                 
            },
            atualizaBanco(){
                this.bancoDeconquistasAux=[];
                for (let elem in this.bancoDeconquistas) {                       
                    this.bancoDeconquistasAux.push(elem + "#" + this.bancoDeconquistas[elem]);
                }
            },
            mostraConquista(conquista){
                let aux  = conquista.split("#")
                return aux[0];
            }


        }
    }
</script>

<style lang="scss" scoped>    
</style>
