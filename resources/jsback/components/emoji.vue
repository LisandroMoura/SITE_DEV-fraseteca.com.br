<template>    
    <div>
        <!-- <button class="open-emoji"
        @click.stop.prevent="mostraEmoji" 
        > :)</button> -->
        <svg 
        @click.stop.prevent="mostraEmoji" 
        class="open-emoji"
        style="max-height:20px" xmlns="http://www.w3.org/2000/svg" 
        width="18" 
        height="18" 
        viewBox="0 0 106.059 106.059" 
        fill="gray"
        >
        <path d="M90.544 90.542c20.687-20.684 20.685-54.341.002-75.024-20.688-20.689-54.347-20.689-75.031-.006-20.688 20.687-20.686 54.346.002 75.034 20.682 20.684 54.341 20.684 75.027-.004zM21.302 21.3c17.494-17.493 45.959-17.495 63.457.002 17.494 17.494 17.492 45.963-.002 63.455-17.494 17.494-45.96 17.496-63.455.003-17.498-17.498-17.496-45.966 0-63.46zM27 69.865s-2.958-11.438 6.705-8.874c0 0 17.144 9.295 38.651 0 9.662-2.563 6.705 8.874 6.705 8.874C73.539 86.824 53.03 85.444 53.03 85.444S32.521 86.824 27 69.865zm6.24-31.194a6.202 6.202 0 1 1 12.399.001 6.202 6.202 0 0 1-12.399-.001zm28.117 0a6.202 6.202 0 1 1 12.403.001 6.202 6.202 0 0 1-12.403-.001z"></path>
        </svg>
        
        <div class="mostrar" v-show="mostrar">                          
            <div class="container">
                <div class="wrapper-editor">
                    <div class="barra-botoes">
                        <ul>                                        
                            <li>                               
                                <!-- <VEmojiPicker showSearch="false" labelSearch="Pesquisar" @select="selectEmoji" /> -->
                                <VEmojiPicker :showSearch="false" @select="selectEmoji" />
                            </li>
                        </ul>
                        <a class="bt-sair bt-sair-emoji" href="#" @click.stop.prevent="sair" title="Fechar esta opção.">
                            <i class="ico ico-sair ico-exit"></i>
                        </a>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>    
   /**
    * // import {uploaders} from  '../../sass/backend/uploaders.scss';
    * // import uploaders from  '../../sass/backend/uploaders.scss';
    * 
    * */

   import VEmojiPicker from 'v-emoji-picker';
//    import packData from 'v-emoji-picker/data/emojis.json';

   
    export default {   
        name:"emoji",  
        props: ['objeto'], 
        components: {
            VEmojiPicker
        },
        data: () => ({
            //pack: packData
            obj:'',
            mostrar:false,
        }),
         mounted() {              
            
        },

        methods: {
            selectEmoji(emoji) {
                //retornar o objeto que chamou
                this.$parent.setaEmoji(emoji, this.objeto)                
                this.sair()
            },
            mostraEmoji(e){
                this.$parent.$children.forEach(element => {
                    if (element.$options._componentTag == "emoji"){                        
                        element.mostrar = false;
                    }
                });                
                this.mostrar = true
            },
            sair(){
                this.mostrar = false
            },
        }
    }
</script>
<style lang="scss">
    // @import '../../sass/backend/uploaders.scss' ; 
</style>
