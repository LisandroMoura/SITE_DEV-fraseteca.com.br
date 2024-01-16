<template>    
    <div> 
        <div class="dialog-modal-novos-posts"
            v-if="lopen">                        
            <div class="wrapper-novas-frases">
                <div class="header-content">
                        <h3 class="header-title">Buscar no Ban
                            <span class="icon-zynga" style="color: rgb(0, 0, 0);"></span>
                             de frases
                        </h3>
                        <a class="bt-sair-pesquisa"
                            v-on:click.stop.prevent="fecharBusca">
                            <i class="ico ico-sair ico-exit"></i>
                        </a>
                </div>
                <div class="container-novos-posts">
                    <div class="row row-form">
                        <div class="col-lg-10 field-input">
                            <input
                            type="text" 
                            class="pesquisar"
                            id="pesquisar" 
                            v-model.lazy="pesquisar" 
                            placeholder="pesquisar pela frase ou pelo Título"
                            v-on:keyup.enter="buscaFrases"                    
                            >
                            
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-success"
                            v-on:click.stop.prevent="buscaFrases">
                            Buscar
                            </button>     
                        </div>                         
                    </div>
                    <input type="hidden" id="pagina" v-model.lazy="pagina">
                    

                    <!-- Índice da busca: {{index_cursor_busca}} -->

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">id</th>
                            <th scope="col">Frase</th>
                            <th scope="col">Status</th>
                            <th scope="col">ação</th>                                
                            </tr>
                        </thead>                        
                        <div
                        v-if="this.semresult"
                        >
                            <span style="color:red">Sem resultados..</span>                        
                        </div>

                        <tbody>
                            <tr                            
                            v-for="(frase, index) in arr_busca"
                            v-bind:key="frase.id"
                            v-bind:index="index"
                            v-bind:title="frase.titulo"                               
                            v-bind:data="frase.frase_id"
                            >
                                <th scope="row">
                                    <a target="_blanck" :href="`/frases/edit/${frase.id}`">
                                        {{frase.id}}                                     
                                        <i class="icon icone icon-012-loupe"
                                        style="font-size: 12px;display: inline;margin:0;">
                                        ver
                                        </i>
                                    </a>
                                    </th>
                                <td>
                                    {{frase.titulo}}
                                </td>                                    
                                <td>
                                    <span
                                        v-if="frase.status==0"
                                        class="atention"                                        
                                        >em pré análise
                                    </span>
                                    <span
                                        v-if="frase.status==1"
                                        class="publicado"                                        
                                        > google
                                    </span>
                                    <span
                                        v-if="frase.status==2"
                                        class="danger"                                        
                                        > NI
                                    </span>
                                    <span
                                        v-if="frase.status==3"
                                        class="danger"                                        
                                        > lixo
                                    </span>
                                    <span
                                        v-if="frase.status==4"
                                        class="reprovada"
                                        > Reprovada
                                    </span>

                                    <span
                                        v-if="frase.status==5"
                                        class="reprovada"
                                        > Duplicada
                                    </span>
                                    <span
                                        v-if="frase.status==51"
                                        class="reprovada"
                                        > Duplicada (uso)
                                    </span>
                                    <span
                                        v-if="frase.status==9"
                                        class="reprovada"
                                        > Lixeira
                                    </span>
                                    
                                </td>                                    
                                <td>                                        
                                    <a href="#"
                                    v-on:click.stop.prevent="insereFrasesDaBusca(frase,index)"                                        
                                    ><i class="fas fa-plus-square"></i>
                                        Inserir
                                    </a>
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
        <!-- dialog-modal-novos-posts        -->
        <div class="container-corpo">
            
            <!-- token: {{token}} <br> -->
            <!-- NEW token: {{token_new}} <br> -->
            <!-- Recalc? : {{recalc}} <br>  -->

            <input type="hidden" name="recalc" id="recalc" v-model.lazy="recalc">
            <div class="recalc" v-show="recalc">
                em alteração...               
                <input type="hidden" name="token" id="token" v-model.lazy="token_new">                
                <input type="hidden" name="novasFrasesTxt" id="novasFrasesTxt" v-model.lazy="novasFrasesTxt">
            </div>
            <div class="corpo-das-frases">
                <div class="tools">
                    <a href="" @click.stop.prevent="marcarVisivelTodasAsImagens" class="botao-padrao flex com-icone red">
                        <i class="ico ico-imagem"></i>
                        Marcar todas as imagens como visíveis
                    </a>

                    <a href="" @click.stop.prevent="desMarcarVisivelTodasAsImagens" class="botao-padrao flex com-icone ">
                        <i class="ico ico-imagem"></i>
                        Desmarcar todas as imagens
                    </a>
                </div>

                <div class="frase-box-wrapper"
                    v-for="(frase, index) in arr_itens"
                    v-bind:key="frase.id"
                    v-bind:index="index"
                    v-bind:title="frase.title"                               
                    v-bind:data="frase.frase_id"
                    >
                    
                    <div v-if="frase.tipo==1"> 
                        <div class="frase-box">
                            <div class="ordem">{{frase.ordem}}º</div>

                            <div class="mostraimage" v-if="frase.mostraimg">
                                <a title="Está exibindo a imagem da frase no corpo da lista">
                                    <i class="ico ico-imagem"></i>
                                </a>                                 
                            </div>
                            <div class="status_frase">
                                <a target="_blank" :href="`/frases/edit/${frase.frase_id}`"
                                    v-if="frase.id!=0"
                                    >
                                    <span class="icon-zynga" style="color: rgb(0, 0, 0);"></span>                                
                                    <span v-if="frase.status!=1" class="naoindexa">
                                        :{{frase.frase_id}}
                                        não indexada                                    
                                    </span>

                                    <span v-else >
                                        google: {{frase.frase_id}}
                                    </span>
                                </a>
                                <a 
                                v-if="frase.new"
                                >
                                | <span style="color:#1fd837;"> inova</span>                                
                                <span class="icon-zynga" style="color: rgb(0, 0, 0);"></span>
                                    
                                </a>
                            </div>                            
                            <div :ref="`zona_visivel_${index}`" class="editando visivel">
                                <span :id="`frase_${index}`">{{frase.frase}}</span>
                                <div class="autor">{{frase.autor}}</div>

                                <div class="barra-botoes">                    
                                    <ul>                                        
                                        <span class="divisor"></span>
                                        <li v-show="!editando">
                                            <a href="#Frase"                            
                                            class="barra-botoes--item"
                                            title="Inserir"
                                            style="padding: 5px 8px;"                                            
                                            @click.stop.prevent="add(index,frase.frase_id,true)"
                                            >+</a>
                                        </li>
                                        <li v-show="!editando">
                                            <a href="#Frase"                            
                                            class="barra-botoes--item"
                                            title="Editar"
                                            style="padding: 5px 8px;"
                                            @click.stop.prevent="habilitarParaEditar(index,true)"
                                            ><span class="ico ico-lapis"></span></a>
                                        </li>
                                        <li>
                                            <a href="#Frase"                            
                                            class="barra-botoes--item"
                                            :title="`Não quero mais isso. Deleta vai? ${frase.id}`"
                                            @click.stop.prevent="removerFrase(index)"
                                            ><span class="ico ico-exit frases"></span></a>
                                        </li>

                                        <li v-show="editando">
                                            <a href="#Frase"                            
                                            class="barra-botoes--item"
                                            @click.stop.prevent="editando=!editando"
                                            title="Salvar"
                                            style="padding: 5px 8px;"
                                            ></a>
                                        </li>
                                        
                                    </ul>                    
                                </div>
                            </div>

                            <div :ref="`zona_edicao_${index}`" class="editando ">
                                <div class="row row-frase-box">
                                    <div class="col-lg-2 label-area">
                                        <label for="">Frase</label>                                    
                                    </div>
                                    <div class="col-lg-10 field-input">
                                        <textarea name="" id="" cols="30" rows="4"
                                        :ref="`frase_${index}`" v-model.lazy="frase.frase"
                                        ></textarea>
                                        <!-- <input type="text" :ref="`frase_${index}`" v-model.lazy="frase.frase"> -->
                                    </div>                                
                                </div>
                                <div class="row row-frase-box">
                                    <div class="col-lg-2 label-area ">
                                        <label for="">Autor</label>
                                    </div>
                                    <div class="col-lg-5 field-input">
                                        <input type="text" name="txt_autor" :ref="`autor_${index}`" :id="`autor_${index}`"  v-model.lazy="frase.autor" >
                                    </div> 

                                    <div class="col-lg-5 field-input" style="line-height: 54px;">
                                        <input type="checkbox" name="escolha" id="escolha" v-model="frase.mostraimg" value="idemA">
                                        <span style="font-size: 14px;">Exibir imagem da frase?</span>
                                    </div> 
                                </div>                                
                                
                                <div class="barra-botoes em-edicao">                    
                                    <ul>
                                        <li>
                                            <a href="#Frase"                            
                                            class="barra-botoes--item botao-padrao white full"
                                            @click.stop.prevent="abreBusca(index,frase.frase_id)"
                                            title="Pesquisar"
                                            ><span clas="ico ico-buscar"></span>Pesquisar</a>
                                        </li>    
                                        <li>
                                            <a href="#Frase"                            
                                            class="barra-botoes--item salvar botao-padrao full green"                                            
                                            @click.stop.prevent="salvar(index, frase.post_id, frase.ordem, frase.tipo,frase.frase_id,'update')"
                                            title="Salvar Agora/Concluir"
                                            ><span clas="ico ico-ss">Concluir</span>
                                            </a>
                                        </li>                                       
                                    </ul>                    
                                </div>
                            </div>                  
                            
                        </div> <!-- frase - box -->

                    </div> <!-- Fim frase tipo 1 -->

                    <!-- frase tipo 2 Anúncios -->
                    <div v-if="frase.tipo==2">
                         <div class="frase-box ads ">
                            <div class="ordem">{{frase.ordem}}º</div>
                            <div class="anuncios">
                                <img src="/images/default/dinheiro.webp" alt="Tipo Anúncios">
                            </div>
                            <a href="#Frase"                            
                            class="botao-padrao con-icone flex full"
                            :title="`Não quero mais isso. Deleta vai? ${frase.id}`"
                            @click.stop.prevent="removerFrase(index)"
                            ><span class="ico ico-lixeira"></span> Excluir</a>
                         </div>
                    </div> 
                    <!-- Fim frase tipo 2 Anúncios -->

                    <!-- Frase tipo 3 Imagens -->
                    <div v-if="frase.tipo==3">
                        <div :id="frase.aux_2" class="frase-box anchor ">
                            <div class="ordem">{{frase.ordem}}º</div> 
                            <div :ref="`zona_visivel_${index}`" class="editando visivel">                           
                                <div class="header">                                                        
                                    <img class="anchor-image" src="/images/default/anchor.jpg" alt="Tipo Imagem">
                                    <h3 class="anchor-title">Anchor Position</h3>
                                </div>
                                <div class="body anchor-body">
                                    <div class="row">
                                        <div class="col1">Título:</div>
                                        <div class="col2">{{frase.aux_1}}</div>
                                    </div>

                                    <div class="row">                  
                                        <div class="col1"></div>                      
                                        <div class="col2 anchor-body-url">@url:{{frase.aux_2}}</div>
                                    </div>
                                </div>
                                <div class="barra-botoes">                    
                                    <ul>                                                                                
                                        <li v-show="!editando">
                                            <a href="#Frase"                            
                                            class="botao-padrao"
                                            title="Editar"
                                            
                                            @click.stop.prevent="habilitarParaEditar(index,true)"
                                            >
                                            <span class="ico ico-lapis"></span>Editar 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#Frase"                            
                                            class="icon-trash-1"
                                            :title="`Não quero mais isso. Deleta vai? ${frase.id}`"
                                            @click.stop.prevent="removerFrase(index)"
                                            >
                                            <span class="ico ico-lixeira"></span> Excluir
                                            </a>
                                        </li>

                                        <li v-show="editando">
                                            <a href="#Frase"                            
                                            class="icon icone icon-floppy-o"
                                            @click.stop.prevent="editando=!editando"
                                            title="Salvar"
                                            style="padding: 5px 8px;"
                                            ></a>
                                        </li>
                                        
                                    </ul>                    
                                </div>
                            </div>
                            <div :ref="`zona_edicao_${index}`" class="editando ">
                                <div class="row row-frase-box">
                                    <div class="col-lg-2 label-area">
                                        <label for="">Titulo</label>                                    
                                    </div>
                                    <div class="col-lg-10 field-input">
                                        <textarea name="" id="" cols="30" rows="4"
                                        :ref="`frase_${index}`" v-model.lazy="frase.aux_1"
                                        ></textarea>                                        
                                        <div class="anchor-url"><strong>@url=</strong> {{frase.aux_2}}</div>                                     
                                    </div>                                         
                                </div>                                
                                <div class="barra-botoes em-edicao">                    
                                    <ul>
                                        <li>
                                            <a href="#Frase"                            
                                            class="botao-padrao green full"                                            
                                            @click.stop.prevent="salvar(index, frase.post_id, frase.ordem, frase.tipo,frase.frase_id,'update')"
                                            title="Salvar Agora"
                                            >salvar agora</a>
                                        </li>                                       
                                    </ul>                    
                                </div>
                            </div>                              
                        </div>
                    </div>
                    <!-- Frase tipo 5 Imagens -->
                    <div v-if="frase.tipo==5">
                        <div :id="frase.aux_2" class="frase-box anchor ">
                            <div class="ordem">{{frase.ordem}}º</div> 
                            <div :ref="`zona_visivel_${index}`" class="editando visivel">                           
                                <div class="header">                                                        
                                    <img class="anchor-image opacity" src="/images/default/privacidade-v01.svg" alt="Tipo Imagem">
                                    <h3 class="anchor-title blue">Caixa de parágrafo</h3>
                                </div>
                                <div class="body anchor-body">
                                    <div class="row">
                                        <div class="col1">Texto do parágrafo (markDown):</div>
                                        <div class="col2 paragrafo">{{frase.aux_1}}</div>
                                    </div>

                                    <!-- <div class="row">                  
                                        <div class="col1"></div>                      
                                        <div class="col2 anchor-body-url">Texto:{{frase.aux_2}}</div>
                                    </div> -->
                                </div>
                                <div class="barra-botoes">                    
                                    <ul>                                                                                
                                        <li v-show="!editando">
                                            <a href="#Frase"                            
                                            class="botao-padrao"
                                            title="Editar"
                                            
                                            @click.stop.prevent="habilitarParaEditar(index,true)"
                                            >
                                            <span class="ico ico-lapis"></span>inserir/Editar 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#Frase"                            
                                            class="icon-trash-1"
                                            :title="`Não quero mais isso. Deleta vai? ${frase.id}`"
                                            @click.stop.prevent="removerFrase(index)"
                                            >
                                            <span class="ico ico-lixeira"></span> Excluir
                                            </a>
                                        </li>

                                        <li v-show="editando">
                                            <a href="#Frase"                            
                                            class="icon icone icon-floppy-o"
                                            @click.stop.prevent="editando=!editando"
                                            title="Salvar"
                                            style="padding: 5px 8px;"
                                            ></a>
                                        </li>
                                        
                                    </ul>                    
                                </div>
                            </div>
                            <div :ref="`zona_edicao_${index}`" class="editando ">
                                <div class="row row-frase-box">
                                    <div class="col-lg-2 label-area">
                                        <label for="">Digite o texto do parágrafo (markDown):</label>                                    
                                    </div>
                                    <div class="col-lg-10 field-input">
                                        <textarea name="" id="" cols="30" rows="4"
                                        :ref="`frase_${index}`" v-model.lazy="frase.aux_1"
                                        ></textarea>                                        
                                        <!-- <div class="cx-text-url"><strong>@Texto=</strong> {{frase.aux_2}}</div>                                      -->
                                    </div>                                         
                                </div>                                
                                <div class="barra-botoes em-edicao">                    
                                    <ul>
                                        <li>
                                            <a href="#Frase"                            
                                            class="botao-padrao green full"                                            
                                            @click.stop.prevent="salvar(index, frase.post_id, frase.ordem, frase.tipo,frase.frase_id,'update')"
                                            title="Salvar Agora"
                                            >salvar agora</a>
                                        </li>                                       
                                    </ul>                    
                                </div>
                            </div>                              
                        </div>
                    </div>
                    
                    <div v-if="frase.tipo==4">
                        <div class="frase-box imagem ">
                            <div class="ordem">{{frase.ordem}}º</div>
                            <div class="imagens convite">
                                <img src="/images/default/contato-v01.svg" alt="Tipo Imagem">
                                <h2>Convite!</h2>
                            </div>
                            <a href="#Frase"                            
                            class="botao-padrao con-icone flex full"
                            :title="`Não quero mais isso. Deleta vai? ${frase.id}`"
                            @click.stop.prevent="removerFrase(index)"
                            ><span class="ico ico-lixeira"></span> Excluir</a>
                        </div>
                    </div>
                    <div class="frase-box-options">      
                        <div :ref="`options_${index}`" class="box-options">
                            <button class="botao-padrao com-icone "
                            v-if="frase.ordem>1"
                            v-on:click.stop.prevent="sobe(index,frase.ordem)" 
                            > <i class="ico ico-seta-acima"></i> </button>                            
                            <button class="botao-padrao com-icone "
                            v-if="frase.ordem<arr_itens.length"
                            v-on:click.stop.prevent="desce(index,frase.ordem)" 
                            > <i class="ico ico-seta-baixo"></i> </button>
                            <span v-if="frase.tipo==1 ||frase.tipo==3">

                                <button class="botao-padrao com-icone "
                                v-on:click.stop.prevent="addNewItem(index,5,frase.post_id)" 
                                >  <i class="ico ico-lapis"></i>(+)parágrafo</button>

                                <button class="botao-padrao com-icone "
                                v-on:click.stop.prevent="addNewItem(index,2,frase.post_id)" 
                                > <i class="ico ico-seguir seguindo"></i>R$</button>

                                <button class="botao-padrao com-icone "
                                v-on:click.stop.prevent="addNewItem(index,4,frase.post_id)" 
                                > <i class="ico ico-curtir curtido"></i></button>

                                
                                <button class="botao-padrao com-icone "
                                v-on:click.stop.prevent="addNewItem(index,3,frase.post_id)" 
                                > <i class="ico ico-minhas-frases-menu"></i> </button>

                                <input class="input_vai_para" type="number" :ref="`vaipara_${index}`" value="0" >

                                <button class="botao-padrao com-icone "
                                v-on:click.stop.prevent="trocaOrdem(index,frase.ordem)" 
                                > <i class="icon-share"></i>...trocar a posição

                                </button>

                            </span>
                        </div>
                    </div> 
                    <!-- frase-box-options -->

                </div> <!-- <div class="frase-box-wrapper" -->
                <div class="row" id="fim">
                    <div class="col-lg-12 text-center pai">
                        <a href="#"
                        class='botao-padrao flex full white ' 
                        title="Acrescentar mais Frases"
                        v-on:click.stop.prevent="addNewItem(this,'1',$parent.idDoPost)"
                        ><span class="ico ico-new"></span>Acrescentar mais Frases                            
                        </a>
                        <div class="add-boxes ">        
                            <label for="numberOfAddBoxes">Número de Frases: </label>
                            <select 
                                class="add-boxes-select"
                                name ="numberOfAddBoxes"
                                v-model="numberOfAddBoxes"
                                id="numberOfAddBoxes">        
                                <option value="1" selected >01</option>
                                <option value="2">02</option>
                                <option value="5">05</option>
                                <option value="10">10</option>        
                                <option value="30">30</option>
                            </select>
                            <button
                            v-on:click.stop.prevent="addFrase"
                            >Inserir</button>
                            <div class="add-boxes-sair pai">
                                <a class="bt-sair bt-sair-emoji"
                                v-on:click.stop.prevent="hideBoxaddFrase"
                                >
                                <i class="ico ico-sair ico-exit"></i></a>
                            </div>
                            
                        </div>
                    </div>     
                </div>      
            </div>
        </div>   
    </div>     
</template>
<script>
    //import computador from  './computador' ;    
    export default {                   
        props: ['opcoes','itens','iddopost'],  
        data () {
            return { 
                arr_itens:[], 
                arr_itens_anterior:[],                 
                novasFrasesTxt:"",
                editando:false,     
                token:"",
                token_new:"",
                recalc:false,                
                frase_atualisada:false,
                numberOfBoxesUsed:10,         
                numberOfAddBoxes:1,
                //buscar frases
                index_cursor_busca:null,
                arr_busca:[],
                pesquisar:'',                
                pagina:'1',
                last_page:'',                
                lopen:false,
                semresult:false,
            }
        },        
        mounted() {              
            this.opt = JSON.parse(this.opcoes)            
            this.arr_itens= JSON.parse(this.itens)
            this.arr_itens_anterior = JSON.parse(this.itens)     
            this.arr_itens.forEach( frase => {
                if(frase.tipo=="3"  || frase.tipo=="5" )
                    this.token+="|tk|"+frase.frase_id+";"+frase.ordem+";"+frase.tipo+";"+frase.aux_1;
                else 
                    this.token+="|tk|"+frase.frase_id+";"+frase.ordem+";"+frase.tipo+";"+frase.mostraimg;
            });
            this.token_new = this.token
        },          
        // computed: {                        
        //     orderedFrases: function () {                         
        //         var self = this                
        //         //self.arr_itens = _.orderBy(self.arr_itens, "ordem", 'asc')
        //         return this.arr_itens;
        //         return _.orderBy(this.arr_itens, 'ordem')
        //     }
        // },          
        methods:{
            desMarcarVisivelTodasAsImagens(e){
                this.arr_itens.forEach( frase => {
                    frase.mostraimg=0
                }); 
                this.chkToken()    
            },
            marcarVisivelTodasAsImagens(e){
                this.arr_itens.forEach( frase => {
                    frase.mostraimg=1
                }); 
                this.chkToken()    
            },
            add(index,frase_id,logical){
                this.habilitarParaEditar(index,logical)
                this.abreBusca(index,frase_id)
            },
            habilitarParaEditar(index,logical){     
                let zona_visivel    = this.$refs["zona_visivel_"+index]
                let zona_edicao     = this.$refs["zona_edicao_"+index]
                let options         = this.$refs["options_"+index]

                if(logical){
                    zona_visivel[0].classList.remove("visivel")
                    zona_edicao[0].classList.add("visivel")    
                    options[0].classList.add("naovisivel")    
                }
                else {
                    zona_visivel[0].classList.add("visivel")
                    zona_edicao[0].classList.remove("visivel")
                    options[0].classList.remove("naovisivel")    
                }                              
            },
            chkToken(){
                this.token_new=""
                let self = this
                this.tokenNovaFrase()
                this.arr_itens.forEach( frase => {
                    //aki colocar o tratamento 
                    if(frase.tipo=="3" || frase.tipo=="5")
                        self.token_new+="|tk|"+frase.frase_id+";"+frase.ordem+";"+frase.tipo+";"+frase.aux_1;
                    else
                        self.token_new+="|tk|"+frase.frase_id+";"+frase.ordem+";"+frase.tipo+";"+frase.mostraimg;

                });                
                if (this.token_new != this.token)
                    this.recalc=true
                else
                    this.recalc=false                
            },
            tokenNovaFrase(){  
                let ncont=0              
                let indexToken=0
                this.novasFrasesTxt=""
                this.arr_itens.forEach( frase => {
                    if(frase.frase_id=="0" && frase.tipo==1){
                        this.novasFrasesTxt+="|nf|"+ncont+"||"+indexToken+"||"+frase.ordem+"||"+frase.frase+"||"+frase.autor+"||"+frase.mostraimg;
                        ncont++
                    }
                    indexToken++                        
                });

                //console.log(this.novasFrasesTxt)
            },
            salvar(index, post_id, ordem,tipo,frase_id,operacao){
                //toda a lógica de salvar aqui
                let self        = this
                let alteracao   = false
                let frase       = this.$refs["frase_"+index]
                let autor       = this.$refs["autor_"+index]                
                
                let txt_autor   = ""
                //testar se vamos alterar o registro na tabela frase                
                if(frase_id!=0 && frase_id!=1){
                    if (operacao=="update"){                                                
                        if(this.arr_itens_anterior[index]){
                            if(frase[0].value)                            
                                if (this.arr_itens_anterior[index].frase.trim() != frase[0].value.trim())
                                    alteracao = true    
                            txt_autor=this.arr_itens_anterior[index].autor
                            if(this.arr_itens_anterior[index].autor==null)
                                txt_autor=""

                            if (txt_autor != autor[0].value)
                                alteracao = true

                            if (alteracao){                            
                                //salvar no banco de dados a tabela frase
                                this.salvarFraseNoBancoViaAxios(index,frase_id,frase[0].value,autor[0].value)
                            }
                        }                            
                    }
                }                
                //desabilitar o campo
                this.habilitarParaEditar(index, false)
                this.chkToken()
            },
            removerFrase(index){
                this.arr_itens.splice(index,1)
                this.recalcularOrdem(index)
                this.chkToken(index)
            },
            recalcularOrdem(index){
                let auxOrdem=1;
                this.arr_itens.forEach( frase => {                    
                    frase.ordem = auxOrdem
                    auxOrdem++
                })

            },
            salvarFraseNoBancoViaAxios(index,frase_id,frase,autor){                
                let self = this
                self.frase_atualisada = false
                //chama o methodo ajax
                const formData = this.getFormData(frase_id,frase,autor)
                axios.post('/frase_up/save',formData)
                .then(respo => {
                    if(respo.data.sucess){
                        this.$parent.validatorJS("Sucesso!", `${respo.data.msg}`, null, "sucesso")
                        self.atualizarArrays(index,frase,autor)
                    }
                    else{
                        self.frase_atualisada = false
                        this.$parent.validatorJS(this.titulo_erro, `${respo.data.msg}`, null, "erro")                        
                    }
                })
                return self.frase_atualisada
            },
            abreBusca(index,frase_id){
                this.index_cursor_busca = index;
                //abre o dialog de busca
                this.lopen = true
            },
            fecharBusca(){
                //array_com os objetos, da busca
                this.arr_busca=[];
                this.pesquisar="";
                this.pagina='1';
                this.lopen=false;
            },
            buscaFrases(query = null){ 
                this.lopen = true;
                this.arr_busca=[];
                this.semresult = false;

                self = this;
                query                   = this.pesquisar;
                let url                 = "";                                
                let pagina              = `${this.pagina}`;                
                let order_by            = 'post';
                if(query) {
                    if (pagina>1)
                        url = `/api/frases/listar_json/${query}?page=${pagina}`;
                    else
                        url = `/api/frases/listar_json/${query}`;                      
                }
                else {
                     if (pagina>1)
                        url = `/api/frases/listar_json/null?page=${pagina}`;                    
                    else
                        url = `/api/frases/listar_json/null`;                      
                } 

                axios.get(url, {})
                    .then(response => {
                        //testar se item já não está no relacionados
                        this.arr_busca = response.data.registros;                        
                        self.last_page = response.data.ultimapagina;

                        if(response.data.registros.length==0)
                            this.semresult=true
                        
                    })
                    .catch(error => {                        
                        this.$parent.validatorJS("Xii", "Erro ao buscar frase", null, "erro")                           
                })
            },
            insereFrasesDaBusca(frase = null, index = null){                
                if(frase.id != this.arr_itens[this.index_cursor_busca].frase_id){
                    this.arr_busca.splice(index,1);
                    
                    this.arr_itens[this.index_cursor_busca].frase_id            = frase.id
                    this.arr_itens[this.index_cursor_busca].titulo              = frase.titulo
                    this.arr_itens[this.index_cursor_busca].frase               = frase.frase
                    this.arr_itens[this.index_cursor_busca].autor               = frase.autor
                    this.arr_itens[this.index_cursor_busca].status              = frase.status
                    this.arr_itens[this.index_cursor_busca].capa                = frase.capa 
                    
                    if(this.arr_itens_anterior[this.index_cursor_busca]){
                        this.arr_itens_anterior[this.index_cursor_busca].frase_id   = frase.id
                        this.arr_itens_anterior[this.index_cursor_busca].titulo     = frase.titulo
                        this.arr_itens_anterior[this.index_cursor_busca].frase      = frase.frase
                        this.arr_itens_anterior[this.index_cursor_busca].autor      = frase.autor
                        this.arr_itens_anterior[this.index_cursor_busca].status     = frase.status                        
                        this.arr_itens_anterior[this.index_cursor_busca].capa       = frase.capa                        
                    }
                    else {
                        //this.arr_itens_anterior.push(this.arr_itens[this.index_cursor_busca])                              
                        this.arr_itens_anterior.push({
                            id:this.arr_itens_anterior.length+1,
                            new:true,
                            ordem:frase.ordem,
                            item_capa :'default',
                            tipo:frase.tipo,
                            post_id :frase.post_id,
                            frase_id:frase.id,
                            titulo :frase.id,
                            frase:frase.frase,
                            autor:frase.autor,
                            status:frase.status,
                            capa:frase.capa,
                        })
                    }                    
                    this.fecharBusca()
                }                
            },
            proximo(){          
                if(this.pagina < this.last_page) {
                    this.arr_busca = [];
                    this.pagina++;      
                    this.buscaFrases();
                }                
            },    
            anterior(){          
                this.arr_busca = [];
                this.pagina--;      
                this.buscaFrases();                  
            },             
            atualizarArrays(index, frase, autor){
                //update screens value
                this.arr_itens[index].frase = frase
                this.arr_itens[index].autor = autor
                this.arr_itens_anterior[index].frase = frase
                this.arr_itens_anterior[index].autor = autor                
            },
            reordenar(){
                this.arr_itens = _.orderBy(this.arr_itens, "ordem", 'asc')
                this.tokenNovaFrase()
            },         
            sobe(index, ordemAtual){                
                this.arr_itens[index-1].ordem = ordemAtual;
                this.arr_itens[index].ordem = ordemAtual - 1;
                this.arr_itens = _.orderBy(this.arr_itens, "ordem", 'asc')
                this.chkToken()
            },
            desce(index, ordemAtual){
                this.arr_itens[index+1].ordem = ordemAtual;
                this.arr_itens[index].ordem = ordemAtual+1;
                this.arr_itens = _.orderBy(this.arr_itens, "ordem", 'asc')
                this.chkToken()
            },
            getFormData(frase_id,frase,autor){
                const formData = new FormData();
                formData.append('frase_id',frase_id)
                formData.append('frase',frase)
                formData.append('autor',autor)                
                // formData.append('aux_1',aux_1)
                // formData.append('aux_2',aux_2)
                
                return formData;
            },           
            addNewItem: function(index, tipo,post_id) {                                
                let ordem=this.arr_itens.length+1  
                let frase = 'Insira aqui a sua nova frase'
                let capa  = "" 
                let id = ordem
                let frase_id=0

                switch (tipo) {
                    //frase
                    case 1:
                        id = ordem
                        frase_id=0
                    break;
                    //anuncio
                    case 2:
                        frase=""
                        ordem=index+1
                        frase_id=1
                    break;
                    //imagem
                    case 3:
                        capa = "/images/default/anchor.jpg"
                        ordem=index+1
                        frase_id=1                        
                    break;
                    
                    case 4:
                        frase=""
                        ordem=index+1                        
                        frase_id=1
                        capa = "/images/default/contato-v01.svg"                        
                    break;
                    case 5:
                        capa = "/images/default/anchor.jpg"
                        ordem=index+1
                        frase_id=1                        
                    break;
                    default:
                        break;
                }
                this.arr_itens.push({
                    id:id,
                    new:true,
                    ordem:ordem,
                    item_capa :'default',
                    tipo:tipo,
                    post_id :post_id,
                    frase_id:frase_id,
                    titulo :'default',
                    frase:frase,
                    mostraimg:0,
                    autor:'',
                    status:'0',
                    capa:capa,
                })

                //console.log(this.arr_itens)

                //recalcular array
                if (tipo>1) {
                    this.reordenar()
                    this.recalcularOrdem(index)
                    this.chkToken()
                }
                
            },
            trocaOrdem: function(index, posicaoAtual) {
                
                let vaiParaPosicao = this.$refs["vaipara_"+index][0].value 


                let auxOrdem=1;                
                let count=0;
                
                this.arr_itens.forEach( frase => {                    
                    if (index == count)
                        frase.ordem = vaiParaPosicao

                    else if (frase.ordem < vaiParaPosicao)                        
                        frase.ordem = auxOrdem
                    
                    else if (
                        frase.ordem >= vaiParaPosicao && frase.ordem < posicaoAtual )
                        frase.ordem = auxOrdem + 1 

                    auxOrdem++
                    count++

                })                
                this.reordenar()
                this.chkToken()                
            },            
        }
    }
</script>
<style lang="scss" scoped>
    .editando{
        display: none;
        &.visivel{
            display: block;
        }
    }
    .mostraimage{
        position: absolute;
        top: 0px;
        left: 35px;
        background: #3490dc;
        color: #fff;
        width: 35px;
        padding-top: 3px;
        height: 35px;
        display: block;
        text-align: center;
        font-size: 22px;
        line-height: 35px;
    }
    .box-options{
        display: block;
        &.naovisivel{
            display: none;
        }
    }
    .atention{
        color:#f79109;
    }
    .danger{
        color:#e52134;
    }
    .reprovada{
        padding: 5px;
        background: #3d4745;
        color: #fff;
        text-decoration: line-through;
    }

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

        .wrapper-novas-frases {
            display: block;
            position: relative;
            width: 100%;
            margin: 0 auto;
            max-width: 600px;
            margin-top: 10px;
            padding: 0px ;
            background: #fff;   
            .header-content{
                margin-bottom: 20px;
            }         
            .container-novos-posts{                
                display: block;
                width: 100%;
                height: 100%;
                padding: 0px 20px 70px 20px;
                .btn.btn-fechar{
                    position: absolute;
                    top:0;
                    right: 0;                    
                }
                .row-form{
                    margin-bottom: 20px;
                    button.btn.btn-success{
                        min-height: 55px;
                    }
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
                            right: 20px;
                        }
                    }
                }
            }
        }
    }
    .frase-box.anchor{
        min-height: 240px;
    }
    .input_vai_para{
        width: 60px;
        margin: 5px 5px 5px 10px;
        height: 36px;        
        text-align: center;
        display: inline-block;        
        padding: 0;
    }
    .anchor-image{
        margin: 0 auto;    
        max-width: 150px;
        position: absolute;
        right: 0;
        bottom: 50px;
        &.opacity{
            opacity: 0.2;
        }
    }

    .paragrafo{
        font-size: 18px;
        display: flex;
        clear: both;
        width: 100%;
        flex-direction: column;
    }
    .anchor-url{
        display: block;
        padding: 8px;
        background: rgba(144, 183, 183, 0.08);
        width: auto;
        color: rgb(100, 98, 98);
        font-size: 14px;
    }
    .anchor-title{
            display: flex;
        justify-content: center;
        align-items: center;
        background:rgb(253, 200, 3);
        padding: 9px 0;
        color: rgb(26, 32, 55);
        position: absolute;
        width: 100%;
        top: 0;
        left: 35px;
        &.blue{
            color:#fff; 
            background:rgb(26, 32, 55);
        }
    }
    .anchor-body{
        margin-top:20px;
        .col1{
            font-weight: 700;
            font-size: 18px;
            margin-right: 15px;
        }
    }
    .anchor-body-url{
        display: block;
        padding: 8px;
        background: rgba(144, 183, 183, 0.08);
        width: auto;
        color: #646262;
        font-size: 14px;
        width: 100%;
        margin-top: 5px;
    }
</style>
