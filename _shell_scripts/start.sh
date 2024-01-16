#!/usr/bin/env bash
# stop - Stop All docker services provide to desenv environment
#
# Website:       https://fraseteca.io
# Author:        lizy by fraseteca.io
# Maintenance:   lizy by fraseteca.io
# reference Docs:
#
# CONFIGURATION?
# I recommend you to create a softlink to folder that is available on $PATH variable.
# $ sudo ln -s /home/ubuntu/repositorio/security/Scripts/Doker/goDocker /usr/local/bin
#
# Crontab:
# sudo vi /etc/crontab
# */5 *    * * *   root    goDocker 1> /dev/null 2>&1
#
# -----------------------------------------------------------------------------#

# ----------------------------VARIABLES--------------------------------------- #
color_default=`tput setaf 69`

config(){
	source config.sh
}

inicio(){
    echo "${color_default} ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
    echo "$(tput sgr0) ${color_default} START docker $(tput sgr0)"
    echo "${color_default} ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
}

up(){
    echo "$(tput sgr0) iniciando compose ${color_default}..."
    docker compose up -d
    read -t3
    echo "${color_default} done!"
}

fim(){
    echo "${color_default} ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
    echo "$(tput sgr0) ───── ● Pronto!-- ${color_default} Sistemas Up em...http://$CLIENT $(tput sgr0) ─────"
    echo "${color_default} ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────"
    echo "$(tput sgr0)"
}
# -----------------------------default process--------------------------------- #
main(){
    config
    inicio
    up
    fim
}
# -------------------------------EXECUTION----------------------------------- #
main
# --------------------------------------------------------------------------- #
