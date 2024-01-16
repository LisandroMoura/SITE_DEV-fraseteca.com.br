
    <?php $rand = rand(1, 999); ?>
    <?php
        $nomeOriginal = $tabela->capa;
        $nomeMobile   = $tabela->nomeMobile;
        $nomeDownload = $tabela->nomeDownload;
        if(!$nomeOriginal) return ;

        /**
         * ● Projeto20221201 - 12-12-22
         *   Trazer a visualização da imagem da frases para as imagens trancadas
         *   além disso, nesta view, trazer o campo de Download jpeg, afim de facilitar
         *   na identificaçao de problemas 
        */
    ?>
    <h1>Principal</h1>
    <h3>Imagem Principal: <?php echo $nomeOriginal; ?></h3>
    <picture class="imagem-normal">
        <source type="image/webp" srcset="<?php echo $nomeOriginal; ?>?ver=<?php echo $rand; ?> 1x">
        <img src="<?php echo $nomeOriginal; ?>?ver=<?php echo $rand; ?>" alt="">
          
        @if ($extension=="jpg")
            <a class="btn-sucess" href="#transformar-em-webp"
                style="background:#4a47b6;color:#fff;padding: .7em 25px; display: block;width: 310px;border-radius: 5px;">
                ir para Transformar em .webp ⬇️
            </a>
        @endif
    </picture>

    <br>
    <br>
    <br>
    <br>
    <h1>Mobile</h1>
    <h3>Arquivo Mobile: <?php echo $nomeMobile; ?></h3>
    <picture class="imagem-normal">
        <source type="image/webp" srcset="<?php echo $nomeMobile; ?>?ver=<?php echo $rand; ?> 1x">
        <img src="<?php echo $nomeMobile; ?>?ver=<?php echo $rand; ?>" alt="">
        <a class="btn-sucess" href="#ajustar-imagem-mobile"
            style="background:#be0b89;color:#fff;padding: .7em 25px; display: block;width: 310px;border-radius: 5px;">
            ir para Regerar imagem Mobile ⬇️
        </a>
    </picture>

    <br>
    <br>
    <br>
    <br>
    <h1>Download JPG</h1>
    <h3>Arquivo de download: <?php echo $nomeDownload; ?></h3>
    <picture class="imagem-normal">
        <source type="image/webp" srcset="<?php echo $nomeDownload; ?>?ver=<?php echo $rand; ?> 1x">
        <img src="<?php echo $nomeDownload; ?>?ver=<?php echo $rand; ?>" alt="">
        
    </picture>