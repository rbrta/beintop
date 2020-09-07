export { default as Footer } from '../..\\components\\Footer.vue'
export { default as Header } from '../..\\components\\Header.vue'
export { default as Logo } from '../..\\components\\Logo.vue'
export { default as ActivateServiceModal } from '../..\\components\\modals\\ActivateServiceModal.vue'

export const LazyFooter = import('../..\\components\\Footer.vue' /* webpackChunkName: "components_Footer" */).then(c => c.default || c)
export const LazyHeader = import('../..\\components\\Header.vue' /* webpackChunkName: "components_Header" */).then(c => c.default || c)
export const LazyLogo = import('../..\\components\\Logo.vue' /* webpackChunkName: "components_Logo" */).then(c => c.default || c)
export const LazyActivateServiceModal = import('../..\\components\\modals\\ActivateServiceModal.vue' /* webpackChunkName: "components_modals/ActivateServiceModal" */).then(c => c.default || c)
