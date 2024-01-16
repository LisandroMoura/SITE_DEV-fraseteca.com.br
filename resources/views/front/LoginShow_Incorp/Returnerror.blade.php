@php
    $titulo     = data_get($errors->all(),'1');
    $descricao  = data_get($errors->all(),'2');
    $textocorpo = session("textocorpo");

    if($textocorpo)
        $descricao = $textocorpo;
    else{
        if (count($errors->all())){
            $descricao="";
            $contLines=0;

            foreach ($errors->all() as $error) {

                $error = str_replace("||email||", "", $error);
                $error = str_replace("||name||", "", $error);
                $error = str_replace("||url||", "", $error);
                $error = str_replace("||nome_completo||", "", $error);
                $error = str_replace("||informacoes_biograficas||", "", $error);

                $contLines++;
                if($error != "1"):
                    if($contLines==count($errors->all()))
                        $descricao.= $error ;
                    else
                        $descricao.= $error . " - " ;
                endif;
            }
        }
    }
@endphp
<strong class="primario">{{$descricao}}</strong>