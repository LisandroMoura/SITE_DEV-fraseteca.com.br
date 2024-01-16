<template>    
    
    <div class="barra-topo">
        <div class="fechar_label">
            Fechando em:{{retorno_msg_timer}}
        </div>
        <a  class="bt_fechar" v-on:click.prevent="fecharRetornoMSGAgora" href="#">
            <span class="bt-fechar-card">
                <i class="fa fa-times"></i>
            </span>
        </a>   
    </div>   
    
</template>
<script>
    // usando as variáveis antes do data
    //let nextTodoId = 1;   
    export default {
        props: ['objeto'],
        data () {
            return {              
                retorno_msg_timer: 6,            
            }
        },

        computed: {                        
            
        },
        watch:{
            
        },
        filters:{
            
        },
        methods: {
            fecharRetornoMSG: function (seconds){            
                var intervalTimer;            
                const now = Date.now();
                const end = now + seconds * 1000;
                intervalTimer = setInterval(() => {
                    const secondsLeft = Math.round((end - Date.now()) / 1000);                        
                    if(secondsLeft === 0) {
                        this.retorno_msg_timer = 0;
                    }        
                    if(secondsLeft < 0) {
                        clearInterval(intervalTimer);
                    return;
                    }
                    this.displayTimeLeft(secondsLeft)
                }, 1000);
            }, 
            displayTimeLeft: function(secondsLeft){
                this.retorno_msg_timer = secondsLeft;
            },     
            fecharRetornoMSGAgora: function (){                            
                this.objeto[0].classe = 'card fechar-fade-out';
                this.objeto[0].obj.innerHTML = '';
            },            
            
        },
        mounted() {
            this.fecharRetornoMSG(6);
        },
        updated() {   
            if(this.retorno_msg_timer == 0)
                this.fecharRetornoMSGAgora();
        },	
    }
</script>