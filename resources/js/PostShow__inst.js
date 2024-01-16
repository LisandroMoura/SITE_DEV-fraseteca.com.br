import {Imprimir} from "./includes/Imprimir"
import {Ajuda} from "./includes/Ajudaaccordion"
import {MenuUsuario} from "./includes/Menuusuario" 
import {ContactForm} from "./includes/Contactform" 
import {Messenger} from "./includes/Messenger"

// import {Copia} from './copia.js'
// import {Salvar} from './salvarFrase.js'
// import {Curtir} from './curtir.js'
// import {Seguir} from './seguir.js'
// import {Comentar} from './comentar.js'

Imprimir.preLoad()
Ajuda.preLoad()
MenuUsuario.preLoad()
ContactForm.preLoad()
Messenger.preLoadPhp()

// Salvar.preLoad()
// Curtir.preLoad()
// Comentar.preLoad()
// Seguir.preLoad()
// Copia.preLoad()

require("../js/includes/Lazy")
require("../js/includes/Lazywebfont")

