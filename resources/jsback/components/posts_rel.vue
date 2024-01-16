<template>    
    <div>        
        <div class="posts-rel"> 
            <h2>Posts Relacionados:</h2>                     
            <div class="posts-wrapp">

                    <ul class="itens-posts">
                        <li class="item-post" 
                            v-for="(post, index) in relacionados"
                            v-bind:key="post.id"
                            v-bind:index="post.post_rel"
                            v-bind:title="post.title"                               
                            v-bind:data="post.post_rel"
                            >
                            <span class="item-post-span">
                                {{post.titulo}}
                            </span>
                            <span class="item-post-span fechar"
                            v-on:click.stop.prevent="removePost(index,post.post_rel)"
                            ><i class="icon-cancel icon post-rel icon-x"></i></span>
                        </li>                    
                    </ul>

                    <input 
                    v-model.lazy="txtPostsRelacionados" 
                    id="txtPostsRelacionados"
                    name="txtPostsRelacionados"
                    type="hidden">

                    <!-- criar a área de seleção dos outros posts -->
                    <button class="more"
                    v-if=!lopen
                    v-on:click.stop.prevent="buscaPostsRel">
                    Inserir mais posts...</button>

                    <div class="dialog-modal-novos-posts"
                        v-if=lopen>                        
                        <div class="wrapper-novos-posts">
                            <div class="container-novos-posts">
                                <input
                                type="text" 
                                id="pesquisar" 
                                v-model.lazy="pesquisar" 
                                placeholder="pesquisar pelo título"
                                v-on:keyup.enter="buscaPostsRel"                    
                                >
                                <input type="hidden" id="pagina" v-model.lazy="pagina">

                                <button class="btn"
                                v-on:click.stop.prevent="buscaPostsRel">
                                Pesquisar</button>

                                
                                <button class="btn btn-fechar"
                                v-on:click.stop.prevent="fecharBusca">
                                fechar X</button>

                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Titulo</th>                                
                                        <th scope="col">ação</th>                                
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr
                                        v-if="testaJaRelacionados(post.titulo,post.id)" 
                                        v-for="(post, index) in lista"
                                        v-bind:key="post.id"
                                        v-bind:index="post.id"
                                        v-bind:title="post.titulo"                               
                                        v-bind:data="post.post_rel">
                                            <th scope="row">{{post.id}}</th>
                                            <td>
                                                {{post.titulo}}
                                            </td>                                    
                                            <td>                                        
                                                <a href="#"
                                                v-on:click.stop.prevent="insereRelacionados(post,index)"                                        
                                                ><i class="fas fa-plus-square"></i>
                                                    Inserir
                                                </a>
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <th scope="row">{{post.id}}</th>
                                            <td style="text-decoration: line-through;color:#ccc">
                                                {{post.titulo}}
                                            </td>
                                            <td>
                                                --
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
            
                                <ul class="btn-navegacao">
                                    <li class="navega prev" v-show="this.pagina>1">
                                        <a class="bt-navega anterior"  href="#"
                                        @click.stop.prevent="anterior"
                                        >
                                        Anterior                                        
                                        </a>                        
                                    </li>                            
                                    <li class="navega next" v-show="this.pagina < this.last_page">
                                        <a class="bt-navega proximo"  href="#"
                                        @click.stop.prevent="proximo"
                                        >
                                        Próximo                                        
                                        </a>                        
                                    </li>
                                </ul>
                            </div>        
                        </div>
                    </div> 
                </div>                
            </div>                     
        </div>      
    </div>     
</template>

<script>    
    export default {     
        props: ['opcoes','postrel','iddopost'],   
        data () {
            return { 
                lista:[],
                opt:[],
                relacionados:[],
                id:[],
                pesquisar:'',                
                pagina:'1',
                last_page:'',                
                lopen:false, 
                idPostsRelacionados:[],
                txtPostsRelacionados:"",
            }
        },
        mounted() {              
            this.opt = JSON.parse(this.opcoes);
            this.id = this.iddopost;
            if(this.postrel)
                this.relacionados= JSON.parse(this.postrel);
            this.montaPostRel();
        },
        watch:{
            pesquisar: function (novoValor, velhoValor) {
                if(velhoValor !="" && velhoValor != novoValor) {                    
                    this.pagina='1';
                }
            }
        },
        methods:{
            testaJaRelacionados(postTitulo,idDaLista){
                let lok=1;
                self = this;
                //testar se já não está relacionado
                this.relacionados.forEach( elemento => {                    
                    if(postTitulo == elemento.titulo){                        
                        lok=0;                        
                    }                                        
                });
                //testar o id do Post
                if(idDaLista == self.id){                    
                    lok=0;
                }
                return lok;
            },
            fecharBusca(){
                this.lista=[];
                this.pesquisar="";
                this.pagina='1';
                this.lopen=false;
            },
            buscaPostsRel(query = null){ 
                this.lopen = true;
                this.lista=[];
                self = this;
                query                   = this.pesquisar;
                let url                 = "";                                
                let pagina              = `${this.pagina}`;
                let perPageUnsplash     = self.opt.perPageUnsplash;
                let order_by            = 'post';
                if(query) {
                    if (pagina>1)
                        url = `/api/posts/listar_json/${query}?page=${pagina}`;
                    else
                        url = `/api/posts/listar_json/${query}`;                      
                }
                else {
                     if (pagina>1)
                        url = `/api/posts/listar_json/null?page=${pagina}`;                    
                    else
                        url = `/api/posts/listar_json/null`;                      
                } 

                axios.get(url, {})
                    .then(response => {
                        //testar se item já não está no relacionados
                        this.lista = response.data.registros;                        
                        self.last_page = response.data.ultimapagina;
                        
                    })
                    .catch(error => {                        
                        this.lista =error                         
                })
            },
            removePost(index,post){
                self = this;
                let id = 0;
                this.relacionados.forEach(element => {                                                            
                    if(element.post_rel==post) {                        
                        this.relacionados.splice(id,1);
                    }
                    id++;
                });
                this.montaPostRel();                
            },
            insereRelacionados(post = null, index = null){
                if(
                    !this.relacionados.includes(post) &&
                    !this.idPostsRelacionados.includes(post)
                    ){
                    post['post_rel']=post.id;
                    this.relacionados.push(post); 
                    this.lista.splice(index,1);
                    this.idPostsRelacionados.push(post.id);
                }
                this.montaPostRel();
            },
            montaPostRel(){
                this.txtPostsRelacionados="";
                this.relacionados.forEach(ele => {
                    this.txtPostsRelacionados += ele.post_rel + ','; 
                });
            },
            proximo(){          
                if(this.pagina < this.last_page) {
                    this.lista = [];
                    this.pagina++;      
                    this.buscaPostsRel();
                }                
            },    
            anterior(){          
                this.lista = [];
                this.pagina--;      
                this.buscaPostsRel();                  
            },    
            ///////////////                            
        }
    }
</script>

<style lang="scss" scoped>
    .dialog-modal-novos-posts {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;        
        z-index: 99999;
        overflow: scroll;            
        transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1);
        background: #0d0d0d52;

        .wrapper-novos-posts {
            display: block;
            width: 100%;
            margin: 0 auto;
            max-width: 600px;
            margin-top: 60px;
            padding: 20px 20px 70px 20px;
            background: #fff;
            .container-novos-posts{
                position: relative;
                display: block;
                width: 100%;
                height: 100%;
                .btn.btn-fechar{
                    position: absolute;
                    top:0;
                    right: 0; 
                }
                ul.btn-navegacao{
                    display: block;
                    list-style-type: none;
                    padding: 0;

                    a.bt-navega {
                        display: block;
                        position: absolute;                        
                        background: #343434;
                        padding: 8px;
                        color: #f2f2f3;
                        &.proximo{
                            right: 0;

                        }
                    }
                }
            }
        }
    }
    
</style>
