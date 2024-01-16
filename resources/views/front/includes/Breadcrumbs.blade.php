@php
    if(!isset($strtabela)) return;
    $home = [
        "bread" => env("APP_NAME"),
        "link"  => env("APP_URL"),
        "type"  => "bread"
    ];

    // dd($strtabela);
    
    $final = [
        "bread" => isset($titulo) ? $titulo : null,
        "link"  => isset($urlamigavel) ? $urlamigavel : null,
        "type"  => "final"
    ];

    switch ($strtabela) {
        case 'posts':
            $intermediario = ["bread" => "Frases",   "link"  => "/page/frases","type"   => "bread"];
            $breadcrumbs[] = $home;
            $breadcrumbs[] = $intermediario;
            $breadcrumbs[] = $final;
            break;
        case 'frase'; 
        case 'frases':
            $intermediario    = ["bread" => "Frases",  "link"  => "/page/frases","type"   => "bread"];
            $breadcrumbs[] = $home;
            $breadcrumbs[] = $intermediario;
            $breadcrumbs[] = $final;
            break;
        case 'autor':
            $intermediario     = ["bread" => "Autores", "link"  => "/page/toplistas","type"   => "bread"];
            $breadcrumbs[] = $home;
            $breadcrumbs[] = $intermediario;
            $breadcrumbs[] = $final;
            break;

        case 'search':
            $intermediario    = ["bread" => "Pesquisa",  "link"  => null, "type"   => "final"];
            $breadcrumbs[] = $home;
            $breadcrumbs[] = $intermediario;
            break;
        case 'institucional':
            $intermediario      = ["bread" => "Posts",   "link"  => "/page/toplistas","type"   => "final"];
            $breadcrumbs[] = $home;
            $breadcrumbs[] = $final;
            break;
        case 'page':
            $intermediario      = ["bread" => "Posts",   "link"  => "/page/toplistas","type"   => "final"];
            $breadcrumbs[] = $home;
            $breadcrumbs[] = $final;
            break;

        case 'cat':
            $intermediario   = ["bread" => "Sessão",   "link"  => "/page/todas-as-tags", "type"   => "bread"];
            $breadcrumbs[] = $intermediario;
            $breadcrumbs[] = $final;
            break;
        case 'tag';     
        case 'tags';             
        case 'archive':
            $breadcrumbs[] = $home;
            if(env("APP_URL") .  "/page/todas-as-tags" == $final["link"]){
                $intermediario   = ["bread" => "Tags",   "link"  => null, "type"   => "final"];
                $breadcrumbs[] = $intermediario;
                
            } else{
                $intermediario   = ["bread" => "Tags",   "link"  => "/page/todas-as-tags", "type"   => "bread"];
                $breadcrumbs[] = $intermediario;
                $breadcrumbs[] = $final;
            } 
            break;
        case 'institucional':
            $intermediario = [];
            
        break;
        default:$intermediario = [];break;

        
    }
@endphp
<div class="breadcrumbs">
    @foreach ($breadcrumbs as $breadcrumb)
        @if (isset($breadcrumb["bread"]))
            @if ($breadcrumb["type"]=="final")
                <a class="breadcrumbs--items">{{ $breadcrumb["bread"] ?? "Fraseteca" }}</a>
            @else
                <a href="{{ $breadcrumb["link"] ?? "" }}" class="breadcrumbs--items">{{ $breadcrumb["bread"] ?? "Fraseteca" }}</a>
                    <span class="separador">/</span>
                    
            @endif
        @endif
    @endforeach
</div>
