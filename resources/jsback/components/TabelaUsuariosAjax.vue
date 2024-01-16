<template>
    <div class="container vue-js-component">
        <div class="row justify-content-center">            
            <div class="col-md-8">
                <div class="well ">
                    Filtrar: <input type="text" name="filtrar" id="filtrar" class="form-control fadeIn second" placeholder="Digite aqui o seu filtro" v-model="model_filtro" >
                </div>
                <div ref="card" class="card">                                       
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
            })
        }	
    }
</script>