@php
  $logado = \Auth::user();
  $avatar = $logado->getAvatarAttribute();
  $pagina = isset($pagina) ? $pagina: "favoritas";
  
  
  if(isset($amp)) $amp=false;
  
  $nComments  = \App\Services\NotificAdm::getPendingQuantity("comments");
  $nCommentsFrases = \App\Services\NotificAdm::getPendingQuantity("comments_frases");
  $nAprovacao = \App\Services\NotificAdm::getPendingQuantity("aprovacao");     
  $nRemessas = \App\Services\NotificAdm::getPendingQuantity("remessas");       

@endphp     

<div class="menu menu-usuario">
    <h4>Menu</h4>
    <nav class="navbar">            
      <ul class="navbar-nav">

        <li class="separador markup">░░░░ ◉ Tarefas</li>  
        <li class="nav-item  <?php if ($pagina == "parametros") echo "active";?>" >
          <a href="{{route('listas.gestaoListasAdmin',"ativas")}}" title="Parâmetros">
          <i class="icon criar-lista"></i>
          Remessas da Marta
            @if ($nRemessas > 0)
              <div class="notification">
                      {{$nRemessas}}
              </div>   
            @endif    
          </a></li>
          <li class="nav-item  <?php if ($pagina == "aprovacoes") echo "active";?>" >
            <a href="{{route('admin.gestao_aprovacao','todos')}}" title="Aprovações">
            <i class="icon icone icon-baidu"></i>                        
              Aprovações
              @if ($nAprovacao > 0)
              <div class="notification">
                  <span>
                      {{$nAprovacao}}
                  </span>
              </div>                        
            @endif
            </a>         
            
        </li>
        <li class="separador markup">░░░░ ◉ Itens</li>   
        <li class="nav-item  <?php if ($pagina == "posts") echo "active";?>">
            <a href="{{route('admin.gestao_posts','todos')}}" title="Posts">
                <i class="icon icone icon-007-copy  "></i>
                Post(Listas)
            </a>
        </li>      
        <li class="nav-item  <?php if ($pagina == "paginas") echo "active";?>">
          <a href="{{route('admin.gestao_posts','institucional')}}" title="Posts">
              <i class="icon icone icon-files-o "></i>
              Post(Páginas)
          </a>
        </li>      

        <li class="nav-item  <?php if ($pagina == "frases") echo "active";?>">
          <a href="{{route('admin.gestao_frases','todas')}}" title="Frases">
              * Banco de frases
          </a>
        </li>  
    
        <li class="nav-item  <?php if ($pagina == "comentarios") echo "active";?>" >
            <a href="{{route('admin.gestao_comments','todos')}}" title="Comentários">
              <i class="icon icone icon-megaphone"></i>
              Comentários
              @if ($nComments > 0)
              <div class="notification">
                  <span>
                      {{$nComments}}
                  </span>
              </div>                        
            @endif
            </a></li>

            <li class="nav-item  <?php if ($pagina == "comentarios") echo "active";?>" >
              <a href="{{route('admin.gestao_comments_frases','todos')}}" title="Comentários">
                <i class="icon icone icon-megaphone"></i>
                Comentários de Frases
                @if ($nCommentsFrases > 0)
                <div class="notification">
                    <span>
                        {{$nCommentsFrases}}
                    </span>
                </div>                        
              @endif
              </a></li>

            {{-- Cadastros --}}
            <li class="separador markup">░░░░ ◉ Cadastros</li>   
            <li class="nav-item  <?php if ($pagina == "autor") echo "active";?>" >
              <a href="{{ route('admin.gestao_autor','todos') }}" title="Autor">
              <i class="icon icon-user"></i>
              Criando Autores
            </a></li>
            <li class="nav-item  <?php if ($pagina == "categorias") echo "active";?>" >
              <a href="{{ route('admin.gestao_categoria','todos') }}" title="Categorias">
              <i class="icon criar-lista"></i>
              Sessão (categorias)
            </a></li>
            <li class="nav-item  <?php if ($pagina == "tags") echo "active";?>
          "><a href="{{route('admin.gestao_tag','todos')}}" title="Tags">
              <i class="icon painel"></i>
              Tags</a>
            </li>

            <li class="nav-item  <?php if ($pagina == "conquista") echo "active";?>" >
            <a href="{{route('admin.gestao_conquitas','todas')}}" title="Conquistas">
            <i class="icon icone icon-star"></i>
            Conquistas</a></li>

            <li class="nav-item  <?php if ($pagina == "usuarios") echo "active";?>" >
              <a href="{{route('admin.gestao_usuarios','ativos')}}" title="Usuários">
              <i class="icon icone icon-zynga"></i>
              Usuários</a></li>

           

            <li class="nav-item  <?php if ($pagina == "midia") echo "active";?>" >
              <a href="{{route('admin.gestao_midias','todas')}}" title="Biblioteca de Mídia">
              <i class="icon icone icon-010-picture"></i>
              Biblioteca</a></li>

            {{-- setup --}}
            <li class="separador markup">░░░░ ◉ Config</li>   

            
           

        

          <li class="nav-item  <?php if ($pagina == "parametros") echo "active";?>" >
            <a href="{{route('marlon')}}" title="Parâmetros">
            <i class="icon criar-lista"></i>
            Marlon</a></li>


        <li class="nav-item  <?php if ($pagina == "banner") echo "active";?>" >
            <a href="{{route('admin.sitemap')}}" title="Sitemap">
            <i class="icon favorito"></i>
            SiteMap</a></li>      
            
        <li class="nav-item  <?php if ($pagina == "parametros") echo "active";?>" >
              <a href="{{route('admin.parametros','todos')}}" title="Parâmetros">
              <i class="icon criar-lista"></i>
              Parâmetros</a></li> 
        
        
         
      </ul>             
  </nav>
     
</div>