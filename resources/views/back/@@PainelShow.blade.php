@extends('template.Admin')

@section('css-view')
@endsection

@section('metadados')
     @include('back.includes.Backend', [
         "titulo" => "Painel de Admin",
         "descricao" => "Fraseteca, Painel de opções do usuário"
     ])     
@endsection

@section('conteudo-menu') 
       
@endsection

@section('conteudo-view')
    @php
        $default_page="painel";

        $nComments  = \App\Services\NotificAdm::getPendingQuantity("comments");
        $nCommentsFrases  = \App\Services\NotificAdm::getPendingQuantity("comments_frases");
        $nAprovacao = \App\Services\NotificAdm::getPendingQuantity("aprovacao");      

    @endphp
    <div class="page" id="app">
        @include('front.includes.Retorno')
        <bt-confirma :confirma="objConfirma"></bt-confirma>
        @include('back.includes.Menulateral')
        @include('back.includes.Areapesquisa')
        <div class="corpo-da-pagina" >
            @include('back.includes.Topo' , ["amp" => false])

            <div class="container corpo">            
                <div class="wrapper">
                    <!-- Sidebar -->
                    <div id="sidebar" class="normal" ref="ref_sidebar">
                            @include('back.includes.Menu' ,[
                               "pagina" => $default_page,
                               "amp" => false,
                            ])
                    </div>
                    <div id="botao"
                    ref="ref_botao"
                    class="only-mobile"
                    @click.prevent.stop="abreSidebar">
                        <span class="linha "></span>
                        <span class="linha linha2"></span>
                        
                    </div>  
                
                    <!-- Page Content -->
                    <div id="content" class="default-form {{$default_page}}">
                        @if ( $errors->any())
                            @if ($errors->first() == false && $errors->first() !='sucesso' )
                                <h1> {{$errors->all()['1']}}</h1>
                                <p>{{$errors->all()['2']}}</p>
                            @endif     
                        @endif
                        {{-- startMagic --}}
                        <div class="container">
                            <h1>Painel</h1>                            
                        </div>

                        {{-- Pendẽncias --}}
                        <div class="content-wrapper">                            
                            <header>
                                <h1>
                                    <i class="icon favorito"></i>
                                    Pendências ({{intval($nComments)  +  intval($nCommentsFrases)  + intval($nAprovacao) }})
                                </h1>
                            </header>

                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Revisões e aprovações de listas, comentários entre outros</h3>
                                    </div>                                            
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <ul>
                                            <li><a href="{{route('admin.gestao_aprovacao','todos')}}">Aprovar/revisar listas
                                                @if ($nAprovacao > 0)
                                                    <strong style="color:red;">({{$nAprovacao}}) pendentes</strong> 
                                                @endif                                                 
                                                </a></li>
                                            <li><a href="{{route('admin.gestao_comments','todos')}}">Aprovar comentários 
                                                
                                                @if ($nComments > 0)
                                                    <strong style="color:red;">({{$nComments}}) pendentes</strong> 
                                                @endif

                                            </a></li>

                                            <li><a href="{{route('admin.gestao_comments_frases','todos')}}">Aprovar comentários de Frases
                                                
                                                @if ($nCommentsFrases > 0)
                                                    <strong style="color:red;">({{$nCommentsFrases}}) pendentes</strong> 
                                                @endif

                                            </a></li>


                                        </ul>
                                    
                                    </div>
                                </div>                                
                            </section>                             
                        </div>
                        {{-- Cadastros --}}
                        <div class="content-wrapper">                            
                            <header>
                                <h1>
                                    <i class="icon favorito"></i>
                                    Cadastros
                                </h1>
                            </header>

                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Criação e edição de Posts, Listas, categorias, tags e muito mais.</h3>
                                    </div>                                            
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <ul>
                                            <li><a href="{{route('admin.gestao_usuarios','ativos')}}">Gestão de Usuários</a></li>
                                            <li><a href="{{route('admin.gestao_posts','todos')}}">Gestão de Posts</a></li>
                                        </ul>
                                        <h3>Outros cadastros</h3>
                                        <ul>
                                            <li><a href="{{route('admin.gestao_posts','todos')}}">Categorias</a></li>
                                            <li><a href="{{route('admin.gestao_posts','todos')}}">Tags</a></li>
                                            
                                        </ul>
                                    
                                    </div>
                                </div>                                
                            </section>                             
                        </div>

                        {{-- Parâmetros --}}
                        <div class="content-wrapper">                            
                            <header>
                                <h1>
                                    <i class="icon favorito"></i>
                                    Parâmetros
                                </h1>
                            </header>

                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Parãmetros gerais do sistema, as imagens da biblioteca de mídias e os Banners da home.</h3>
                                    </div>                                            
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <ul>
                                            <li><a href="{{route('admin.gestao_posts','todos')}}">Parâmetros gerais</a></li>
                                            <li><a href="{{route('admin.gestao_midias','todas')}}">Gestão de Mídias</a></li>
                                            <li><a href="{{route('admin.gestao_banner','todos')}}">Imagem de capa</a></li>                                            
                                        </ul>
                                    </div>
                                </div>                                
                            </section>                             
                        </div>


                          

                        {{-- endMagic --}}    
                    </div>  
                </div>               
            </div>

            {{-- foter --}}
            @include('front.includes.Footer')
        </div> 
    </div>
@endsection
@section('js-view')    
    <script src="{{ asset('js/back_end_favoritas.js') }}?ver={{env('VER')}}"></script>
@endsection