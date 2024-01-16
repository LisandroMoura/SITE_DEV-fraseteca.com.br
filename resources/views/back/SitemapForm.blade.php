@extends('template.Usuario')

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
       
        $default_page="sitemap";

    @endphp
    <div class="page" id="app">
        @include('front.includes.Retorno')
        <bt-confirma :confirma="objConfirma"></bt-confirma>
        @include('back.includes.Menulateral')
        @include('front.includes.Areapesquisa')
        <div class="corpo-da-pagina" >
            @include('back.includes.Topo', ["amp" => false])

            <div class="container corpo">            
                <div class="wrapper">
                    <!-- Sidebar -->
                    <div id="sidebar" class="normal" ref="ref_sidebar">
                            @include('back.includes.Menu' ,[
                               "pagina" => $default_page
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
                            <h1>Gerando os SiteMap</h1>
                        </div>

                        {{-- Sitemaps --}}
                        <div class="content-wrapper">                            
                            <header>
                                <h1>
                                    <i class="icon favorito"></i>
                                    Sitemaps gerados
                                </h1>
                            </header>

                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>
                                            <a href="/sitemap.xml"> - Sitemap.xml (Ver)</a>
                                        </h3>
                                        <h3><a href="/sitemap_frases_part1.xml"> - Sitemap_frases_part1.xml (Ver)</a></h3>
                                        <h3><a href="/sitemap_frases_part2.xml"> - Sitemap_frases_part2.xml (Ver)</a></h3>
                                        <h3><a href="/sitemap_frases_part3.xml"> - Sitemap_frases_part3.xml (Ver)</a></h3>
                                        <h3><a href="/sitemap_frases_part4.xml"> - Sitemap_frases_part4.xml (Ver)</a></h3>
                                        <h3><a href="/sitemap_frases_part5.xml"> - Sitemap_frases_part5.xml (Ver)</a></h3>
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
                                        <h3>Em desenvolvimento ainda.</h3>
                                    </div>                                            
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <ul>
                                            <li>Em desenv</li>
                                            <li>Em desenv</li>
                                            <li>Em desenv</li>
                                        </ul>
                                    </div>
                                </div>                                
                            </section>                             
                        </div>
                        {{-- Gerar --}}
                        <div class="content-wrapper">                            
                            <header>
                                <h1>
                                    <i class="icon favorito"></i>
                                    Gerar
                                </h1>
                            </header>

                            <section>                                                                                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Clique no botão abaixo para gerar um novo arquivo.</h3>
                                    </div>                                            
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">

                                        <form class="form-box" 
                                            action="{{ route('admin.sitemap')}}" method="POST">
                                            {{ csrf_field() }}                                    
                                            @method('PUT')
                                            <button>Gerar Sitemap Normal</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">

                                        <form class="form-box" 
                                            action="{{ route('admin.sitemapfrases')}}" method="POST">
                                            {{ csrf_field() }}                                    
                                            @method('PUT')
                                            <button>Gerar Sitemap de Frases</button>                                    
                                        </form>    
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