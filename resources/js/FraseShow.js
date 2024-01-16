import { Copia } from "./includes/Copia"
import { Imprimir } from "./includes/Imprimir"
import { MenuUsuario } from "./includes/Menuusuario"

import { Salvar } from "./includes/Salvarfrase" //Isso ta muito grande
import { Curtir } from "./includes/Curtir"
import { Seguir } from "./includes/Seguir"
import { Comentar } from "./includes/Comentar"
import { Messenger } from "./includes/Messenger"
import { Compartilhar } from "./includes/Compartilhar"

MenuUsuario.preLoad()
Curtir.preLoad()
Comentar.preLoad()
Seguir.preLoad()
Copia.preLoad()
Imprimir.preLoad()
Messenger.preLoadPhp()
require("../js/includes/Lazy")
require("../js/includes/Lazywebfont")