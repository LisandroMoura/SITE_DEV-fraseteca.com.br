import { MenuUsuario } from "./includes/Menuusuario"
import { Messenger }   from "./includes/Messenger"
import {InputMagic}    from "./includes/Inputmagic"
import {ButtonsForm}   from "./includes/Buttonsform"
import {Controller}    from "./includes/Pastascontroller"
import {JSController}  from "./includes/jspuload/Controller"

InputMagic.preLoad()
ButtonsForm.preLoad()
Controller.preLoad()
JSController.preLoad("pastas")
MenuUsuario.preLoad()
Messenger.preLoadPhp()

require("../js/includes/Lazy")
require("../js/includes/Lazywebfont")
