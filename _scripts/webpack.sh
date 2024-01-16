#!/usr/bin/env bash
# webpack.sh - Compilador de arquivos JS e scss para branches específicos
#
# Website:       https://fraseteca.com.br
# Author:        Lisandro Moura Grings
# Maintenance:   Lisandro Moura Grings
# reference Docs: 
#       - --
# CONFIGURATION?
# sudo ln -s /home/ubuntu/repositorio/listafrases.projeto/fraseteca/webpack.sh /usr/local/bin 
# Crontab:
# sudo vi /etc/crontab
# */5 *    * * *   root    bob.sh 1> /dev/null 2>&1
#
# -----------------------------------------------------------------------------#
#
# ----------------------------VARIABLES--------------------------------------- #
clear
branches=$(git branch -a | grep -v "remotes") 
# -----------------------------------------------------------------------------#
#
# ----------------------------VALIDAÇÕES-------------------------------------- #
[ ! $1 ] && {
    echo "$(tput setaf 1) ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
    echo "$(tput sgr0) ───── ● ATENÇÃO!!! Precisa informar um dos parâmetros de Branche abaixo:"
    echo "$(tput setaf 1) ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
    echo "$branches"
    exit 1
}
_IFS=IFS
IFS=$'\n\r'	
validBranche="false"
for linha in $branches
do
    string=${linha:2:${#linha}}    
    [ "$string" = "$1" ] && {
        validBranche="true"
    }
done
IFS=_IFS
[ $validBranche = "false" ] && {
    echo "$(tput setaf 1) ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
    echo "$(tput sgr0) ───── ● ATENÇÃO!!! Precisa informar um dos parâmetros de Branche abaixo:"
    echo "$(tput setaf 1) ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
    echo "$branches"
    exit 1
}
# -----------------------------------------------------------------------------#
#
# --------------------------------RUN----------------------------------------- #

[ $2 ] && {
    if ([ $2 = "watch" ] || [ $2 = "--watch" ]) 
    then
        echo "$(tput setaf 8) ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
        echo "$(tput sgr0) ───── ● Compilando Ambiente: $1 -- $(tput setaf 9) WATCH $(tput setaf 8) ─────"
        echo "$(tput setaf 8) ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
        echo "$(tput sgr0)"
        npm run "$1"-"watch"
    fi
}
echo "$(tput setaf 8) ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
echo "$(tput sgr0) ───── ● Compilando Ambiente: $1 -- $(tput setaf 2) PRODUÇÃO $(tput setaf 8) ─────"
echo "$(tput setaf 8) ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
echo "$(tput sgr0)"
[ "$1" = "master" ] && {
    npm run master
} || {
    npm run "$1"-production
}

# arquivo="HomeShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="PostShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="PostShowAmp"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="FraseShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="FraseShowAmp"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="PerfilShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="ArchiveShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="AutorShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="LoginShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="DefaultShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="SearchShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"


# arquivo="FeedShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"

# arquivo="PastaList"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php" 

# arquivo="PastaForm"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"   

# arquivo="PerfilForm"
# mv "public/BuildCss/$arquivo.css" "resources/views/front/${arquivo}_Incorp/Css.blade.php"   


# ####################### ADMIN
# arquivo="PainelShow"
# mv "public/BuildCss/$arquivo.css" "resources/views/back/${arquivo}_Incorp/Css.blade.php"   

# arquivo="PostForm"
# mv "public/BuildCss/$arquivo.css" "resources/views/back/${arquivo}_Incorp/Css.blade.php"   


while read linha
do
    aux=$(echo $linha | grep "VER=2023")
    if [ $aux ];then
        echo "VER=$( date '+%Y_%m%d_%H%M_%S' )"
    else
        echo "$linha"
    fi
done < ".original_env" > .env
# clear
[ "$2" ] && {
    $2
}
exit 0
