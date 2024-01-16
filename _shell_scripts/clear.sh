#!/bin/bash

# Limpar os cache do laravel quando preciso:
# principalmente quando alterar o .env
# 
echo "inicio da limpeza do cache!"
echo 'Clear cache...';
php artisan cache:clear && php artisan config:cache && php artisan config:clear
echo 'End...';
exit 0

    #   cache:clear                  
    #   cache:forget                 
    #   cache:table                  
    #   config:cache                 
    #   event:cache                  
    #   route:cache                  
    #   schedule:clear-cache         
    #   view:cache                   