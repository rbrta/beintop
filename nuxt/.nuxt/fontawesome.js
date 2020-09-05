import Vue from 'vue'
import { library, config } from '@fortawesome/fontawesome-svg-core'
import {
  FontAwesomeLayers,
  FontAwesomeLayersText,
  FontAwesomeIcon
} from '@fortawesome/vue-fontawesome'

import {
  faCog as freeFasFaCog,
  faStar as freeFasFaStar,
  faTh as freeFasFaTh,
  faUser as freeFasFaUser,
  faLongArrowAltLeft as freeFasFaLongArrowAltLeft,
  faLongArrowAltRight as freeFasFaLongArrowAltRight
} from '@fortawesome/free-solid-svg-icons'

library.add(
  freeFasFaCog,
  freeFasFaStar,
  freeFasFaTh,
  freeFasFaUser,
  freeFasFaLongArrowAltLeft,
  freeFasFaLongArrowAltRight
)

config.autoAddCss = false

Vue.component('FontAwesomeIcon', FontAwesomeIcon)
Vue.component('FontAwesomeLayers', FontAwesomeLayers)
Vue.component('FontAwesomeLayersText', FontAwesomeLayersText)
