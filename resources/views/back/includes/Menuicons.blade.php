@php
     $logado = \Auth::user();
     $pagina = isset($default_page) ? $default_page: "";     

     if(!$logado)
     return;

     $mobile_class="";

     if (isset($mobile))
        $mobile_class="wrapper-labreMenuPerfil-hidden-mob";

     $avatar = $logado->getAvatarAttribute();
@endphp

<div class="menu-icons">
    <nav class="navbar">            
        <ul class="navbar-nav">          
          <li class="nav-item  <?php if ($pagina == "bem_vindo") echo "active";?>" >            
              <a 
                 
                 {{-- v-touch-class="'touch-tap'" --}}
                 href="{{route('usuario.feed')}}" 
                 title="Página inicial">
              <i class="icon icone icon-003-home"></i>
              </a> 
              
              

          </li> 
   
          <li class="nav-item  <?php if ($pagina == "favoritas") echo "active";?>">
              <a 
                  href="{{route('usuario.feed')}}" title="Frases Favoritas">
                  <i class="icon icone icon-004-star"></i>
                  
              </a>
          </li>      
          

          {{-- ícone imagem do usuário --}}
          <li class="nav-item  <?php if ($pagina == "perfil") echo "active";?>" >
                <div class="icone-perfil-logado only-mobile"            
                {{-- data-src="{{$avatar}}" --}}
                style="background-size: cover; background-image:url({{$avatar}})">
                <a 
                class="afull"    
                href="{{"/perfil/".$logado->name. '.' .$logado->id}}"
                title="Ver seu perfil"
                rel="nofollow"
                ></a>
                </div>
          </li>

          <li class="nav-item pai <?php if ($pagina == "perfil") echo "active";?> no-mobile">
            <a href="{{route('usuario.edit', $logado->id)}}" title="Editar o Perfil">
            <i class="icon icone icon-user"></i>            
           </a></li>
          
          <li class="nav-item pai <?php if ($pagina == "listas") echo "active";?>">
            <a 
                class="labreMenuPerfil pointer"
                @click="abreMenuPerfil"
                title="Minhas Listas">
                <i class="icon icone icon-down-open" 
                v-bind:class="labreMenuPerfil"
                ></i>
            </a>

            <div class="icon-menu-sub-menu">
                @php
                    $nComments  = 0;$nAprovacao = 0;$pending    = 0;
                    if (isset($functionsAdminPend)){
                        $nComments  = $functionsAdminPend["comments"];
                        $nAprovacao = $functionsAdminPend["aprovacao"];            
                        $pending = $nAprovacao + $nComments;
                    }
                    
                    if (isset($logado))
                        if ($logado->perfil == '1') :
                            
                            $nComments  = \App\Services\NotificAdm::getPendingQuantity("comments");
                            $nAprovacao = \App\Services\NotificAdm::getPendingQuantity("aprovacao");            
                            $pending = $nAprovacao + $nComments;
                        endif;
                    
                @endphp    
                <ul class="wrapper-labreMenuPerfil-hidden labreMenuPerfil pointer {{$mobile_class}} " v-bind:class="labreMenuPerfil">
                    @if ($logado->perfil == '1') 

                        <li class="only-mobile">
                        <a href="{{route('usuario.edit', $logado->id)}}" title="Editar o Perfil">
                        <i class="icon icone icon-user"></i>
                        Editar perfil
                       </a></li>

                        <li><a href="{{route('back.Painel')}}" title="Acessar o Painel do ADMIN">
                            <i class="icon icone icon-006-list"></i>
                            Painel Admim
                        </a></li>                      

                        <li><a href="{{route('admin.gestao_aprovacao','todos')}}" title="Acessar o Painel do ADMIN" class="parent-notification">
                            <i class="icon icone icon-baidu"></i>
                            Aprovações
                            @if ($nAprovacao > 0)
                                <div class="notification">
                                    <span>{{$nAprovacao}}</span>
                                </div>
                            @endif
                        </a></li> 

                        <li><a href="{{route('admin.gestao_comments','todos')}}" 
                            title="Acessar o Painel do ADMIN" class="parent-notification">
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
                        <li><a href="{{route('admin.gestao_posts', 'todos')}}" title="Posts">
                                <i class="icon icone icon-files-o"></i>
                                Gestão Posts</a></li>
                        <li><a href="{{route('admin.gestao_usuarios', 'ativos')}}" title="Gestão de Usuários do Sistema">
                            <i class="icon icone icon-user"></i>
                            Gestão Usuários
                        </a></li>  
                        
                        <li><a href="{{env('APP_URL')}}/admin/monica/" 
                            class=""
                            title="Monica">
                            <i class="icon icone icon-006-list"></i>                            
                                Mônica: Organizadora
                        </a></li>
                        <li><a href="{{env('APP_URL')}}/admin/marlon/" 
                            class=""
                            title="Gestão de Usuários do Sistema">
                            <i class="icon icone icon-zynga"></i>                            
                                Marlon Farejador
                        </a></li>
                        <li><a href="{{ route('admin.gestao_autor','todos') }}" 
                            class=""
                            title="Autor">
                            <i class="icon icone icon-006-list"></i>                            
                                Criando Autores
                        </a></li>
                        
                        
                        <li><a title="Pesquisar"
                            href="#"
                            v-on:click.stop.prevent="abrePesquisa"
                            >
                            <i class="icon icone icon-011-magnifying-glass"></i>
                            Pesquisar</a>
                        </li>
                        
                        <li><a href="{{route("logout")}}" title="Deslogar/Logout">
                            <i class="icon icone icon-logout"></i>
                            Logout</a>
                        </li>
                    @else  
                        <li class="only-mobile">
                        <a href="{{route('usuario.edit', $logado->id)}}" title="Editar o Perfil">
                        <i class="icon icone icon-user"></i>
                        Editar perfil
                       </a></li>
                        <li><a href="{{route('listas.minhasListas','ativas')}}" title="Acessar o Painel">
                            <i class="icon icone icon-006-list"></i>
                            Minhas Listas
                        </a></li>
                        
                        <li><a title="Pesquisar"
                            href="#"
                            v-on:click.stop.prevent="abrePesquisa"
                            >
                            <i class="icon icone icon-011-magnifying-glass"></i>
                            Pesquisar</a>
                        </li>
                        
                        <li><a href="{{route("logout")}}" title="Deslogar/Logout">
                            <i class="icon icone icon-logout"></i>
                            Logout</a>
                        </li>                                         
                        
                    @endif                       
                </ul> 
            </div>
          </li>
        </ul>             
    </nav>
</div>