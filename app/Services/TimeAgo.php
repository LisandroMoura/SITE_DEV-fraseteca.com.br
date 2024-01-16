<?php

namespace App\Services;
/**
 * Class Functions.
 * Classe padrão pas as Funções da aplicação
 * similar ao arquivo functions do Wordpress
 * @package namespace App\Services;
 * @author  LM
 * @link    
 * @version 1.0.0 - Jun-2019
 */
// use App\Entities\Post;
// use App\Entities\Tag;
// use App\Entities\Categoria;
// use App\Entities\Frases;

class TimeAgo 
{    
    public function run($attribute){        
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $data = $this->time_ago_in_php($attribute);
        return $data;
    }
    public function time_ago_in_php($timestamp){
        /***
         * Code refer: https://www.myprogrammingtutorials.com/facebook-like-time-ago-system-in-php.html  
         * */
        $time_ago        = strtotime($timestamp);
        $current_time    = time();
        $time_difference = $current_time - $time_ago;
        $seconds         = $time_difference;
        
        $minutes = round($seconds / 60); // value 60 is seconds  
        $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
        $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
        $weeks   = round($seconds / 604800); // 7*24*60*60;  
        $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
        $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
        
        if ($seconds <= 60){
      
          return "Agora mesmo";
      
        } else if ($minutes <= 60){
      
          if ($minutes == 1){
      
            return "1 min";
      
          } else {
      
            return "$minutes min";
      
          }
      
        } else if ($hours <= 24){
      
          if ($hours == 1){
      
            return "1h";
      
          } else {
      
            return "$hours"."h";
      
          }
      
        } else if ($days <= 7){
      
          if ($days == 1){
      
            return "ontem";
      
          } else {
      
            return "$days" . "d";
      
          }
      
        } else if ($weeks <= 4.3){
      
          if ($weeks == 1){
      
            return "uma semana";
      
          } else {
      
            return "$weeks semanas";
      
          }
      
        } else if ($months <= 12){
      
          if ($months == 1){
      
            return "um mês";
      
          } else {
      
            return "$months"." Meses";
      
          }
      
        } else {
          
          if ($years == 1){
      
            return "um ano atrás";
      
          } else {
      
            return "$years anos atrás";
      
          }
        }
    } 

    
//the end class    
}
