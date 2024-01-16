@extends('templates.master')

@section('css-view')
@endsection

@section('conteudo-menu')
    @php
        $usuariologado = $logado;                                

        // $options = json_encode([
        //     'tipo'=> 'unic',
        //     'tamanho'=> 1024,
        //     'textoTamanho' => '1 MB'
        // ]);

        //$options = '{"tipo":"unic","tamanho":1024,"textoTamanho":"1 MB"}';
    @endphp    
    @if($usuariologado->perfil === '1')
        @include('front.includes.Menu')
    @else
        @include('usuario.usuario_menu')           
    @endif    
    

    {{-- 
        tipo vai ser sempre sistema        
        passar o usuario logado - será sempre o admin
        a url será fixa, com parãmetros gerais sistema
            storage/sistema/
        status será sempre 1)aprovado          
      --}}

@endsection

@section('conteudo-view')
    
    <div class="container col-sm-12">
        <h1 class="titulo">Inserir NOVO Arquivo de MÍDIA</h1>    
    </div>

    <div class="container col-sm-12" id="app">

        @include('front.includes.Retorno')
        <bt-confirma :confirma="objConfirma"></bt-confirma>
        
        <div class="row">                
            <div id="area_do_form" class="container">        
                <div class="row">
                    <form 
                        action="{{ route('midia.store')}}" 
                        method="post" >                        
                         <div class="row">                                                        
                            <div class="col">
                                <div class="forms ">
                                    <label class="field ">
                                        <h4>Tipo de mídia:</h4>  
                                        <input type="text" name="ref_tipo" name="ref_tipo" value="">                                  
                                        @include('front.includes.formulario.Radio',    ['input' => 'tipo','label' => 'Do Sistema (capas)', 'value' => '1', 'checked' => 'true' , 'vmodel' => 'tipo' ])
                                        @include('front.includes.formulario.Radio',    ['input' => 'tipo','label' => 'Do usuário (capas)', 'value' => '2', 'checked' => 'false' , 'vmodel' => 'tipo'   ])                                        
                                        @include('front.includes.formulario.Radio',    ['input' => 'tipo','label' => 'Avatar Do usuário', 'value' => '4', 'checked' => 'false' , 'vmodel' => 'tipo' ])                                        
                                        @include('front.includes.formulario.Radio',    ['input' => 'tipo','label' => 'Avatar Para a Biblioteca', 'value' => '5', 'checked' => 'false' , 'vmodel' => 'tipo' ])                                        
                                        
                                        @{{tipo}}

                                    </label>
                                </div>
                            </div>                            
                        </div>           
                        <div class="row">
                            <div class="col">   
                                
                                <div class="well">
                                    <div class="card">
                                        <div class="container">
                                            <h3>Faça o upload da Imagem</h3>                                            
                                            <upload opcoes="{{$options}}"></upload>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                        </div>       
                        
                        
                        {{ csrf_field() }}
                        
                        
                        {{-- <div class="select-container">                     --}}
                            {{-- @include('front.includes.formulario.Select',    ['input' => 'pais','label' => 'País:', 'dados' => $lista_dados ])                 --}}
                        {{-- </div>  --}}
        
                        @include('front.includes.formulario.Hidden',    ['input' => 'usuario_id','value' => $logado->id])
                        @include('front.includes.formulario.Hidden',    ['input' => 'status','value' => '1'])
                        @include('front.includes.formulario.Hidden',    ['input' => 'remember_token','value' => '{{csrf_token()}}'])
                        
                        {{-- <div class="select-container col"> 
                            @include('templates.formularios.submit',[
                                'input' => 'add',
                                'label' => 'Inserir'
                                ])
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>    
@endsection
@section('js-view')    
    <script src="{{ asset('js/upload.js') }}"></script>
@endsection