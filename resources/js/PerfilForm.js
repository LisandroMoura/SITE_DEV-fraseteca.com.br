import { MenuUsuario }  from "./includes/Menuusuario"
import { Perfil }       from "./includes/Perfil"
import { Messenger }    from "./includes/Messenger"
import {JSController}   from "./includes/jspuload/Controller"

MenuUsuario.preLoad()
Perfil.preLoad()
Messenger.preLoadPhp()
JSController.preLoad("perfil")


require("../js/includes/Lazy")
require("../js/includes/Lazywebfont")
