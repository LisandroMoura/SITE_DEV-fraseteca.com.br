import { CallLogin } from "./includes/Calllogin"
Messenger.preLoadPhp()

import { Checkradiobox } from "./includes/Checkradiobox"
Checkradiobox.preLoad()

import { Messenger } from "./includes/Messenger"
CallLogin.preLoad()

require("../js/includes/Lazy")
require("../js/includes/Lazywebfont")

