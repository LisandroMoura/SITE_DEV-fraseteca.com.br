<template>
    <div class="container vue-js-component">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p>{{descricaoText}}</p>                         
                        <div class="well">
                            <input type="text" name="filtrar" id="filtrar" class="form-control" placeholder="Filtro" v-model="filterTerm" >
                        </div>
                    </div>
                    <div class="card-body">
                         <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><a href="#" target="_blank" v-on:click.stop.prevent="ordenar('id')" rel="noopener noreferrer">Id<span class="arrow"></span></a></th>
                                    <th><a href="#" target="_blank" v-on:click.stop.prevent="ordenar('name')" rel="noopener noreferrer">Nome <span class="arrow"></span> </a></th>
                                    <th><a href="#" target="_blank" v-on:click.stop.prevent="ordenar('email')" rel="noopener noreferrer">Email <span class="arrow"></span></a></th>
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
        props: ['users'],
        data () {
            return {
                descricaoText: '',  
                lista: [],
                sortProperty:'name',                
                sortDirection:1,
                filterTerm: '',
            }
        },
        mounted() {
            this.descricaoText = 'Componente 2) TABELA DE USUARIOS: Texto vindo do Componente, quando o mesmo foi montado',
            this.lista = JSON.parse(this.users)
            this.filterTerm = ''
        },
        computed: {            
            listaOrdenada: function () {         
                var self = this                                       
                return self.lista.filter(function (user) {
                    return user.name.indexOf(self.filterTerm) !== -1
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
            }
        }	
    }
</script>