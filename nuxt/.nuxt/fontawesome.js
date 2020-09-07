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
  faLongArrowAltRight as freeFasFaLongArrowAltRight,
  faHeart as freeFasFaHeart,
  faEye as freeFasFaEye,
  faHome as freeFasFaHome
} from '@fortawesome/free-solid-svg-icons'

library.add(
  freeFasFaCog,
  freeFasFaStar,
  freeFasFaTh,
  freeFasFaUser,
  freeFasFaLongArrowAltLeft,
  freeFasFaLongArrowAltRight,
  freeFasFaHeart,
  freeFasFaEye,
  freeFasFaHome
)

config.autoAddCss = false

Vue.component('FontAwesomeIcon', FontAwesomeIcon)
Vue.component('FontAwesomeLayers', FontAwesomeLayers)
Vue.component('FontAwesomeLayersText', FontAwesomeLayersText)
