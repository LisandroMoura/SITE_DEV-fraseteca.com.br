<template>
    <div class="container vue-js-component">
        <div class="row justify-content-center">
            <h1 ref="titulo">Painel</h1>
            <div class="col-md-8">
                <div class="well ">
                    Filtrar: <input type="text" name="filtrar" id="filtrar" class="form-control fadeIn second" placeholder="Digite aqui o seu filtro" v-model="model_filtro" >
                </div>
                <div class="card">
                    <div class="card-header">
                        <p>
                            <img v-bind:src="bind_img" :title="bind_alt">
                        </p>    
                        <p>{{descricaoText}}</p>   
                        <input type="checkbox" name="escolha" id="escolha" v-model="model_escolha" value="idemA">Item a<br>
                        <input type="checkbox" name="escolha" id="escolha" v-model="model_escolha" value="idemB">Item B<br>
                        <input type="checkbox" name="escolha" id="escolha" v-model="model_escolha" value="idemC">Item C<br>

                        <select name="select" id="select"  v-model="model_select">
                            <option value="Opt A">Opt A</option>
                            <option value="Opt B">Opt B</option>
                            <option value="Opt c">Opt C</option>
                            <option value="Opt D">Opt D</option>
                        </select>
                        <br>
                    </div>     

                    <p>
                        Escolhido: {{model_escolha}}
                        Select:  {{model_select}}
                    </p>  
                    <p>
                        IMAGEM: <input type="text" name="" id="" v-model="bind_img">                        
                    </p>
                    <p>
                        <ul>
                            <li 
                            v-for="nome in nomes"
                                    v-bind:key="nome.id"
                                    v-bind:index="nome.id"
                                    v-bind:title="nome.nome"
                                    >
                                    {{nome.id}} - {{nome.nome | filtroFuncaoMaiuscula(descricaoText, 'para2')| filtroTruncar }}

                                    {{nome.id}} - {{nome.nome | filtroFuncaoMaiuscula| filtroTruncar }}

                            </li>

                        </ul>
                    </p>
                    <div class="bt-recarregar">
                        <a href="#" target="_blank" v-on:click.stop.prevent="reload" rel="noopener noreferrer" title="Atualiza">
                            <img src="/img/refresh.png" alt="Reload" width="30px" height="30px">    
                        </a>
                        
                    </div>             
                    <div class="card-body">
                         <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><a href="#" target="_blank" v-on:click.stop.prevent="ordenar('id')" rel="noopener noreferrer">Id<span class="arrow"></span></a></th>
                                    <th><a href="#" target="_blank" v-on:click.stop.prevent="ordenar('name')" rel="noopener noreferrer">Nome <span class="arrow"></span> </a></th>
                                    <th><a href="#" target="_blank" v-on:click.stop.prevent="ordenar('email')" rel="noopener noreferrer">Email <span class="arrow"></span></a></th>
                                    <th><a href="#" target="_blank" v-on:click.stop.prevent="ordenar('perfil')" rel="noopener noreferrer">Perfil <span class="arrow"></span></a></th>
                                    <th><a href="#" target="_blank" v-on:click.stop.prevent="ordenar('status')" rel="noopener noreferrer">Status <span class="arrow"></span></a></th>
                                </tr>
                            </thead>
                            <tbody>                                
                                <tr                                  
                                    v-for="(user, index_do_array_interno_do_for) in listaOrdenada"
                                    v-bind:key="user.id"
                                    v-bind:index="user.id"
                                    v-bind:title="user.name"                                    
                                    >
                                    <th>{{index_do_array_interno_do_for}} - {{user.id}}</th>
                                    <th>{{user.name}}</th>
                                    <th>{{user.email}}</th> 
                                    <th>
                                        <div v-if="user.perfil === '1'">
                                            Admin
                                        </div>                                        
                                        <div v-else-if="user.perfil === '2'">
                                            Revisor
                                        </div>                                        
                                        <div v-else>
                                            usuário
                                        </div>
                                         <!-- {{user.perfil}}  -->
                                    </th> 
                                    <th>
                                        <div v-if="user.status === '2'">
                                            2)Suspenso
                                        </div>                                        
                                        <div v-else-if="user.status === '3'">
                                            3)Deletado
                                        </div>                                        
                                        <div v-else>
                                            1)Ativo 
                                        </div> 
                                        <!-- {{user.status}} -->                                        
                                    </th> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    // usando as variáveis antes do data
    //let nextTodoId = 1;   
    export default {
        //props: ['users'],
        data () {
            return {
                descricaoText: '',  
                lista: [],                
                sortProperty:'name',                
                sortDirection:1,
                model_filtro: '',
                model_escolha:[],
                model_select:[],
                bind_img: 'https://picsum.photos/90/90',
                bind_alt: 'Opa lele',
                nomes:[
                    {id: '1', nome: 'Mingau'},
                    {id: '2', nome: 'Mingau'},
                    {id: '3', nome: 'Mingau'},
                    {id: '4', nome: 'batata'},
                    {id: '5', nome: 'Jonas'},
                    {id: '6', nome: 'Cebolas'},
                ]
            }
        },

        computed: {                        
            listaOrdenada: function () {         
                var self = this                                       
                return self.lista.filter(function (user) {
                    return user.name.indexOf(self.model_filtro) !== -1
                })                
            }            
        },
        watch:{
            model_filtro: function (novoValor, velhoValor) {
                console.log(novoValor);
                console.log(velhoValor);
            }
        },
        filters:{
            filtroFuncaoMaiuscula(str, param1, param2){
                return str.toUpperCase() + ' : ' +param1;
            },
            filtroTruncar(str){
                return str.substring(0,3);
            }
        },
        methods: {
            ordenar: function (campoOrdem) {                
                if(this.sortDirection == 1){
                    this.sortDirection = -1
                    this.lista = _.orderBy(this.lista, campoOrdem, 'desc')
                }   
                else{
                    this.sortDirection = 1
                    this.lista = _.orderBy(this.lista, campoOrdem, 'asc')
                }
            },
            reload: function () {
                axios.get('/api/usuarios/listar_json', {})
                     .then(response => {
                        this.lista = response.data
                        //console.log(response.data)
                     })
                     .catch(error => {
                        this.lista =error 
                        //console.log(error)
                     }
                ) 
            }
        },
        mounted() {
            this.descricaoText = 'LISTA DE USUARIOS AJAX:',            
            //chamada axio AJAX
            //axios.get('http://listadefrases.local.br/api/usuarios/listar_json', {})
            axios.get('/api/usuarios/listar_json', {})
                .then(response => {
                    this.lista = response.data
                    //console.log(response.data)
                })
                .catch(error => {
                    this.lista =error 
                    //console.log(error)
            }),
            //console.log(this.$refs.titulo);
        },	
    }
</script>