import { CallLogin } from "./includes/Calllogin"
import {LoadMore} from "./includes/Loadmorepost"
LoadMore.preLoad()
CallLogin.preLoad()

import { Messenger }   from "./includes/Messenger"
Messenger.preLoadPhp()
require("../js/includes/Lazy")
require("../js/includes/Lazywebfont")