<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Entities\Usuario; 
use App\Entities\Categoria; 
use App\Entities\Lista; 

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $loops; 

    public function run()
    {
  
        $loops = 1;

   
  
        Usuario::insert([            
            'name'                              => 'username', 
            'email'                             => 'email@email.com',
            'email_verificado_dt'               => '2020-05-03 01:01:01',
            'password'                          => bcrypt('mypassword'),
            'apelido'                           => 'username',
            'nome_completo'                     => 'username',
            'remember_token'                    => 'asdsdasdasd',
            'data_nascimento'                   => '1978-11-08',
            'sexo'                              => 'M',
            'perfil'                            => '1',
            'status'                            => '1',
            'avatar_icone_id'                   => '',
            'informacoes_biograficas'           => 'Admin do site.',
            'receber_news'                      => '0',
            'receber_comentarios_notificacao'   => '0',
            'pasta'                             => '00001',
            'url'                               =>'',
        ]);

        Categoria::insert([            
            'descricao'                         => 'sem categoria', 
            'resumo'                            => 'sem categoria',
            'urlamigavel'                       => 'sem-categoria',
            'status'                            => '0',
            'disponivel'                        => '1',

        ]);

         
        //$this->call(UsersTableSeeder::class);
    } 
}