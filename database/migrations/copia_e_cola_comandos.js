<script>

/*JÁ Execudados:

php artisan make:migration create_honrarias --create honrarias
php artisan make:migration create_honrarias_usuarios --create honrarias_usuarios

php artisan make:migration create_listas --create listas
php artisan make:migration create_listas_favoritas --create listas_favoritas

php artisan make:migration create_midias --create midias
php artisan make:migration create_categorias --create categorias

php artisan make:migration create_pontuacao_lista --create pontuacao_lista
php artisan make:migration create_comentario_da_lista --create comentario_da_lista

php artisan make:migration create_parametros_globais --create parametros_globais
php artisan make:migration create_palavrao --create palavrao

php artisan make:migration create_denuncias --create denuncias

php artisan make:migration create_posts --create posts

php artisan make:migration create_tagposts --create tagposts
php artisan make:migration create_categoriaposts --create categoriaposts

php artisan make:migration create_comments --create comments

php artisan make:migration create_topobanner --create topobanner

php artisan make:entity FrasesFavoritas

php artisan make:entity Frases

php artisan make:entity PastaUsuario
php artisan make:entity PastaUsuarioItem
php artisan make:entity Feed

php artisan make:migration create_tagposts --create tagposts

php artisan make:entity TagFrases

PS::: Sempre é bom criar a Entitie, pois já cria o controller com os methodos corretos

*/
Tabela comments

//
/**
 * 
 * Campos DA TABELA
 */
/*
        /* usuarios */
            $table->string("nome_completo",255); 
            $table->string("nome_de_usuario",255); 
            $table->string("email",255); 
            $table->date("email_verificado_dt")->nullable(); 
            $table->string("senha",255); 
            $table->bigInteger("nascimento_dia");
            $table->bigInteger("nascimento_mes");
            $table->bigInteger("nascimento_ano");
            $table->string("sexo",1);
            $table->string("perfil",11);
            $table->string("status",11);
            $table->string("avatar_icone_id",255);
            $table->longText("informacoes_biograficas")->nullable();
            $table->string("receber_news",11)->nullable();
            $table->string("receber_comentarios_notificacao",11)->nullable();  

            //usa-se o tipo char para campos pequenos
            $table->char("quer_ligacao",1)->nullable();              

            //valores default
            $table->string("situacao",80)->default('ativo');              

            /**/listas
  
            * foreignkeys 
  
            $table->unsignedBigInteger('honraria_id');
            $table->foreign('honraria_id')->references('id')->on('honrarias');

            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');

            //foreignkeys   
            $table->unsignedBigInteger('lista_id');
            $table->foreign('lista_id')->references('id')->on('listas')->ondDelete('cascade');

*/

/*
php artisan migrate


php artisan make:controller Post --resource


 */
</script>