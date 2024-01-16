<?php
// ● Projeto20221201  = desativar a função em view isMobile()
//   Não é uma boa prática em templates blade criar uma function.
// function isMobile($options): bool
// {
//     $mobile = false;
//     if (isset($options['keyYandex'])) {
//         if (isset($_SERVER['HTTP_USER_AGENT'])) {
//             if ($options['keyYandex'] == 'true') {
//                 $user_agents = ['iPhone', 'iPad', 'Android', 'webOS', 'BlackBerry', 'iPod', 'Symbian', 'IsGeneric'];
//                 foreach ($user_agents as $user_agent) {
//                     if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== false) {
//                         $mobile = true;
//                         break;
//                     }
//                 }
//             }
//         }
//     }
//     return $mobile;
// }
