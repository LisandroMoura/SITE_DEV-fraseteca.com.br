@php
    /**--------------------------------------------------------------------------------------------------------------
     * Nome: PerfilShow_incorp/Item.blade.php
     * Autor: LM
     * Objetivo: View Item do HTML do perfil - mostrando as listas de itens dessa página 
     * Doc: 
     * -------------------------------------------------------
     * UPDATES:
     * -------------------------------------------------------
     * ● Fraseteca2023Set03 - problemas na no uso da distribuição
     *     >> 26-09-23 - ajustar o link da navegação
     *--------------------------------------------------------------------------------------------------------------*/
    use App\Entities\Usuario;
    $cont = 0;
@endphp

@if (count($dados))

    <div class="container-full relacionadas-wrapper no-print">
        <ul class="{{ $classUl ?? 'itens' }} {{ $tipo }}">
            @foreach ($dados as $item)
                @php
                    $cont++;
                    $urlamigavel = $item->urlamigavel;
                    $titulo = $item->titulo;
                    $capa = $item->thumb;
                    $total = $dados->total();
                    $path = $dados->resolveCurrentPath();
                    $lastPage = $dados->lastPage();
                    $perPage = $dados->perPage();
                    $currentPage = $dados->currentPage();

                    if ($accordion != 'listas') {
                        $acheiPerfil = Usuario::find($item->id);
                        $urlamigavel = 'perfil/' . $item->urlamigavel . '.' . $item->id;
                        $titulo = $item->titulo;
                        $capa = 'storage/usuarios/' . $item->id . '/avatar.webp';
                        if ($acheiPerfil) {
                            $capa = $acheiPerfil->getAvatarAttribute();
                        }
                    }
                    
                    $classCapa = 'comcapa';
                    
                    if (trim($capa) === '') {
                        $capa = $item->capa;
                    }
                    if ($capa == '') {
                        $capa = '/images/default/pasta-desktop-v03.svg';
                        $classCapa = 'img-null';
                    }

                    // Fraseteca2023Set03 date: 26-set-2023 // obs: ajustar o link das navegações 
                    $path = str_replace("http://fraseteca.dev.io","https://fraseteca.com.br",$path);
                    $path = str_replace(env("DISTRIBUITION_URL"),"https://fraseteca.com.br",$path);
                
                @endphp
                
                <li class="view-perfil">
                    <div class="imagem-zone">
                        <div class="cantos-arredondados-para-pastas {{ $classCapa }}"></div>
                        @if ($amp)
                            <div class="box-amp-img">
                                <a href="/{{ $urlamigavel }}" target="blank"
                                    class="relacionadas-link-imagem-zone-amp {{ $tipo }}"
                                    title="{{ $titulo }}">
                                    <amp-img class="lazy-hidden" src="{{ $capa }}" width="187" height="151"
                                        layout="responsive" alt="Imagem de {{ $titulo }}">
                                    </amp-img>
                                </a>
                            </div>
                        @else
                            @if ($classCapa == 'img-null')
                                <a href="/{{ $urlamigavel }}"
                                    class="{{ $classCapa }} relacionadas-link-imagem-zone {{ $tipo }}"
                                    title="Pasta: {{ $item->titulo }}">
                                    @if ($accordion == 'listas')
                                        <img src="/images/pasta-desktop-v03.svg" alt="{{ $item->titulo }}"
                                            class="img-marcacao {{ $classCapa }}">
                                    @endif
                                    <span class="span-bg {{ $classCapa }} {{ $tipo }}" style="background-image:url({{ $capa }})"></span>
                                </a>
                            @else
                                <a href="/{{ $urlamigavel }}" target="blank"
                                    class="{{ $classCapa }} relacionadas-link-imagem-zone {{ $tipo }}"
                                    title="Pasta: {{ $item->titulo }}" {{-- style="background-image:url({{$capa}})" --}}>
                                    
                                    @if ($accordion == 'listas')
                                        <img src="/images/default/pasta-desktop-v03.svg" alt="{{ $item->titulo }}" class="img-marcacao {{ $classCapa }}">
                                    @endif
                                    <span class="span-bg {{ $tipo }}" style="background-image:url({{ $capa }})"></span>
                                </a>
                            @endif
                        @endif
                    </div>

                    <div class="texto-zone {{ $tipo }} @if ($amp) amp @endif ">
                        <a href="/{{ $urlamigavel }}" target="blank" title="{{ $titulo }}">
                            {{ $titulo }}
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@else (!count($dados))
    <div class="no-content">
        <div class="imagem-principal">
            @if ($mobile)
                <img src="/images/default/dormindo-no-ponto-mob-v01.svg" width="213" height="179" alt="Perdidão total">
            @else  
                <img src="/images/default/dormindo-no-ponto-v01.svg" width="262" height="220" alt="Perdidão total">
            @endif
        </div>
        <h2>Dormindo no Ponto!</h2>
        @if (isset($link_description))
            <a class="aqui_tem_link"
                    href="{{ $link_description }}">{{ $description ?? 'O usuário não tem bibliotecas no momento' }}</a>
        @else
            <span> {{ $description ?? 'O usuário não tem bibliotecas no momento' }}</span>
        @endif
    </div>
    @php
        return;
    @endphp
@endif
@if ($lastPage > 1)
    <div class="wrapper-navegacao-perfil">
        @include('front.includes.Navegacao', [
            'amp' => false,
            'accordion' => $accordion,
            'lastPage' => $lastPage,
            'currentPage' => $currentPage,
            'path' => $path,
            // 'query' => '&pesquisar=all',
        ])
    </div>
@endif
