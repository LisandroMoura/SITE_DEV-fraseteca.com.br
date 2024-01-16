<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{descricaoText}}</div>

                    <div class="card-body">
                        COMPONENTE DE EXEMPLO
                    </div>
                </div>
            </div>
        </div>
        <hr><hr><hr><hr><hr>
    </div>
</template>

<script>
    export default {
        props: ['titulo'],
        data () {
            return {
                descricaoText: '',                  
            }
        },
        mounted() {
            this.descricaoText = this.titulo,
            console.log('Component mounted.')
        }
    }
</script>
