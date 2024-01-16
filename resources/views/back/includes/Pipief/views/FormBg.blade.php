<?php
$pastaItems = $pastaItems ?? []; 
if(isset($parametros["font"])) return ;
$fonte              =  $parametros["fonte"] ;
$corFonte           =  $parametros["corFonte"] ;
$fonteAutor         =  $parametros["fonteAutor"];
$sizeFonte          =  $parametros["sizeFonte"] ;
$quebra             =  $parametros["quebra"];
$align              =  $parametros["align"] ;
$sizeAutor          =  $parametros["sizeAutor"] ;
$marginTop          =  $parametros["marginTop"] ;
$marginRight        =  $parametros["marginRight"] ;
$marginBottom       =  $parametros["marginBottom"];
$marginLeft         =  $parametros["marginLeft"];
$qualidade          =  $parametros["qualidade"];
// $pasta              =  $parametros["pasta"];
$imagemEscolhida    = $parametros["imagemEscolhida"];
$tipoTela           = $parametros["tipoTela"] ;


?>
<form ref="formulario" action="{{ route('frase.runPipif') }}" method="post" enctype="multipart/form-data">
    @method('get')
    <input type="hidden" name="id" id="id" value="<?php echo $idTabela;?>">
    <input type="hidden" name="tipoTela" id="tipoTela" value="<?php echo $tipoTela;?>">

    <h1>Tipo: 612x612 - Fundo com imagem</h1>
    Frase:<h4>{{ $frase; }} - {{ $autor }} </h4>
    <ul class="pasta">
        <li>
            <div class="col">Pasta</div>
            <div class="col"><input type="hidden" name="pasta_h" id="pasta_h" value="<?php echo $pasta; ?>">
                <select name="pasta" id="pasta">
                    <option <?php if ($pasta == 'amor') {
                        echo 'selected';
                    } ?> value="amor">Amor</option>
                    <option <?php if ($pasta == 'aniver') {
                        echo 'selected';
                    } ?> value="aniver">Aniver</option>
                    <option <?php if ($pasta == 'deus') {
                        echo 'selected';
                    } ?> value="deus">Deus</option>
                    <option <?php if ($pasta == 'familia') {
                        echo 'selected';
                    } ?> value="familia">Familia</option>
                    <option <?php if ($pasta == 'denoite') {
                        echo 'selected';
                    } ?> value="denoite">The Noite</option>
                    <option <?php if ($pasta == 'feminino') {
                        echo 'selected';
                    } ?> value="feminino">Feminino</option>
                    
                    <option <?php if ($pasta == 'friends') {
                        echo 'selected';
                    } ?> value="friends">Friends</option>

                    <option <?php if ($pasta == 'girls') {
                        echo 'selected';
                    } ?> value="girls">Girls</option>

                    <option <?php if ($pasta == 'motivacao') {
                        echo 'selected';
                    } ?> value="motivacao">Motivação</option>
                    
                    <option <?php if ($pasta == 'pensativo') {
                        echo 'selected';
                    } ?> value="pensativo">Pensativo</option>

                    <option <?php if ($pasta == 'sad') {
                        echo 'selected';
                    } ?> value="sad">Sad</option>
                    
                    <option <?php if ($pasta == 'pets') {
                        echo 'selected';
                    } ?> value="pets">Pets</option>
                    
                    <option <?php if ($pasta == 'manha') {
                        echo 'selected';
                    } ?> value="manha">Manhã</option>
                    
                </select>
            </div>
        </li>
        <li>
            <input type="hidden" name="imagemEscolhida" id="imagemEscolhida" value="<?php echo $imagemEscolhida; ?>">
            <ul class="imagens-na-pasta" id="imagens-na-pasta">
                <?php $id = 0;
                $class="";
                ?>
                <?php foreach ($pastaItems as $key => $item) { ?>
                    <?php 
                    $class = '';
                    $numeros = explode('.png', $item);
                    if ($numeros[1]) {
                        $id = $numeros[0];
                    }
                    
                    $escolhido = explode($imagemEscolhida . '.', $item);
                    if(isset($escolhido[1]))
                        if ($escolhido[1] && $escolhido[0] == '') {
                            $class = 'escolhida';
                        }
                    ?>
                    <li><a href="#" class="imgEscolhida <?php echo $class; ?>" data_id="<?php echo $id; ?>">
                            <img class="no-pointer" src="<?php echo env("APP_URL")?>/storage/frases/template/<?php echo $pasta; ?>/<?php echo $item; ?>"
                                alt="" class="">
                        </a></li>
                <?php } ?>
            </ul>
        </li>
    </ul>
    <ul class="flex">
        <li>
            <div class="col">Cor</div>
            <div class="col"><input type="text" name="corFonte" id="corFonte" value="<?php echo $corFonte; ?>"></div>
        </li>
        <li>
            <div class="col">Font Size(px)</div>
            <div class="col"><input type="text" name="sizeFonte" id="sizeFonte" value="<?php echo $sizeFonte; ?>"></div>
        </li>
        <li>
            <div class="col">Entrelinhas</div>
            <div class="col"><input type="text" name="quebra" id="quebra" value="<?php echo $quebra; ?>"></div>
        </li>
        <li>
            <div class="col">Align:</div>
            <div class="col">
                <!-- <input type="text" name="align" id="align" value="<?php //echo $align;
                ?>"> -->
                <select name="align" id="align">
                    <option value="0" <?php if ($align == '0') {
                        echo ' selected';
                    } ?>>None</option>
                    <option value="1" <?php if ($align == '1') {
                        echo ' selected';
                    } ?>>Middle</option>
                    <option value="2" <?php if ($align == '2') {
                        echo ' selected';
                    } ?>>Top</option>
                    <option value="3" <?php if ($align == '3') {
                        echo ' selected';
                    } ?>>Bottom</option>
                </select>
            </div>
        </li>
        <!--
            <li>
                <div class="col">Size Autor</div>
                <div class="col"><input type="text" name="sizeAutor" id="sizeAutor" value="<?php echo $sizeAutor; ?>"></div>
            </li> -->
        <li>
            <div class="col">Top</div>
            <div class="col"><input type="text" name="marginTop" id="marginTop" value="<?php echo $marginTop; ?>">
            </div>
        </li>
        <li>
            <div class="col">Right</div>
            <div class="col"><input type="text" name="marginRight" id="marginRight" value="<?php echo $marginRight; ?>">
            </div>
        </li>
        <li>
            <div class="col">Bottom</div>
            <div class="col"><input type="text" name="marginBottom" id="marginBottom" value="<?php echo $marginBottom; ?>"></div>
        </li>
        <li>
            <div class="col">Left</div>
            <div class="col"><input type="text" name="marginLeft" id="marginLeft" value="<?php echo $marginLeft; ?>">
            </div>
        </li>
        <li>
            <div class="col">Qualidade %</div>
            <div class="col"><input type="number" name="qualidade" id="qualidade" value="<?php echo $qualidade; ?>">
            </div>
        </li>
        <li>
            <input type="hidden" name="tipoTela" id="tipoTela" value="<?php echo $tipoTela; ?>">
        </li>
    </ul>
    <button type="submit" class="enviar" style="width: 100%; height:110px;"> Gerar imagem da Frase </button>
</form>
