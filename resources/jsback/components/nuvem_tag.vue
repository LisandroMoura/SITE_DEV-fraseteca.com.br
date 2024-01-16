<template>    
    <div>        
        <div class="nuven-detag"> 
            <h2>Tags:</h2>                     
            <div class="caixatag">                
                <ul class="item-nuvem">
                    <li class="item-tag" data=""
                        v-for="(tag, index) in tagsDoPostAux"
                                v-bind:key="tag.id"
                                v-bind:index="tag.id"
                                v-bind:title="tag.descricao"   
                                v-on:click.stop.prevent="removeTagNoPost(index,tag)"
                        >
                        {{tag}}                      
                        <span class="fechar">
                            <i class="icon-cancel icon tag icon-x"></i>
                        </span>
                    </li>
                </ul>                                    
                <div class="row">
                    <div class="col">
                        <input 
                        v-model.lazy="txtInserir" 
                        type="text" 
                        class="txt_inserir_nova"
                        placeholder="inserir nova tag,">                        
                        <button class="txt_inserir_nova_button"
                        v-on:click.stop.prevent="inserirNovaTag"                        
                        >Inserir</button>
                        <input 
                        v-model.lazy="txtTagsNovas" 
                        id="txtTagsNovas"
                        name="txtTagsNovas"
                        type="hidden"                         
                        >
                    </div>
                </div>

                <div class="caixatag adcionar">
                       <h5>Nuvem de tags:</h5> 
                    <ul class="item-nuvem">                       
                        <li class="item-tag" data=""
                            v-for="(tag, index) in bancoDetagsAux"
                            v-bind:key="tag.id"
                            v-bind:index="tag.id"
                            v-bind:title="tag.descricao"
                            v-on:click.stop.prevent="addTagNoPost(index,tag)"
                            > 
                            {{tag}}                            
                            <span class="fechar">
                                <i class="icon-cancel icon tag icon-x"></i>
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
        props: ['opcoes','listatags','tagdados'],   
        data () {
            return { 
                tagsDoPost:[],
                tagsDoPostAux:[],
                bancoDetags:[], 
                bancoDetagsAux:[], 
                opt:[],                
                txtInserir:'',
                tagsNovas:[],
                txtTagsNovas:"",
            }
        },
        mounted() {              
            this.opt            = JSON.parse(this.opcoes)               
            this.tagsDoPost     = JSON.parse(this.listatags);
            this.atualizaTag();            
            this.bancoDetags    = JSON.parse(this.tagdados);
            this.atualizaBanco();
            this.atualizaCampoTag();
        },
        methods:{
            inserirNovaTag(){
                let arrTxtInserir =this.txtInserir.split(",");
                arrTxtInserir.forEach(ele =>{   
                    if(!this.bancoDetagsAux.includes(ele) && 
                       !this.tagsDoPostAux.includes(ele) &&
                       !this.tagsNovas.includes(ele))                    
                        this.tagsDoPostAux.push(ele);                    
                        this.tagsNovas.push(ele);                        
                });
                this.txtInserir="";
                this.txtTagsNovas="";
                this.tagsNovas.forEach(ele => {
                    this.txtTagsNovas += ele + ','; 
                });
                this.atualizaCampoTag();
            },
            addTagNoPost(index,tag){ 
                self= this;
                let id = 0;
                this.bancoDetagsAux.forEach(element => {                                        
                    if(element==tag) {
                        this.tagsDoPostAux.push(tag);
                        this.bancoDetagsAux.splice(id,1);                        
                    }
                    id++;
                });
                this.atualizaCampoTag();
            },
            removeTagNoPost(index,tag){
                self = this;
                let id = 0;
                this.tagsDoPostAux.forEach(element => {                                        
                    if(element==tag) {
                        this.bancoDetagsAux.push(tag);
                        this.tagsDoPostAux.splice(id,1);
                    }
                    id++;
                });
                this.atualizaCampoTag();
            },
            atualizaTag(){                
                this.tagsDoPostAux=[];
                 for (let elem in this.tagsDoPost) { 
                    this.tagsDoPostAux.push(elem);                                                        
                }
            },
            atualizaCampoTag(){
                var pai = this.$parent;                
                pai.tags= "";
                this.tagsDoPostAux.forEach(ele=> {                    
                    pai.tags += ele+',';
                });                 
            },
            atualizaBanco(){
                this.bancoDetagsAux=[];
                for (let elem in this.bancoDetags) {                      
                    this.bancoDetagsAux.push(elem);                
                }
            },                   
        }
    }
</script>

<style lang="scss" scoped>    
</style>
