import { MenuUsuario } from "./includes/Menuusuario"
import {LoadMore} from "./includes/Loadmorepost"
import { Messenger }   from "./includes/Messenger"
Messenger.preLoadPhp()
LoadMore.preLoad()
MenuUsuario.preLoad()
require("../js/includes/Lazy")
require("../js/includes/Lazywebfont")

