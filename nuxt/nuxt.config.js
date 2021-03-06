require("dotenv").config();

export default {
  /*
   ** Nuxt rendering mode
   ** See https://nuxtjs.org/api/configuration-mode
   */
  mode: "universal",
  /*
   ** Nuxt target
   ** See https://nuxtjs.org/api/configuration-target
   */
  target: "server",
  /*
   ** Headers of the page
   ** See https://nuxtjs.org/api/configuration-head
   */
  head: {
    title: process.env.npm_package_name || "",
    titleTemplate: "%s | Be-in-top",
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      {
        hid: "description",
        name: "description",
        content: "Раскрутка вашего Instagram аккаунта"
      }
    ],
    link: [
      { rel: "icon", type: "image/x-icon", href: "/beintop-fav.png" },
      {
        rel: "stylesheet",
        href:
          "https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      }
    ]
  },

  env: {
    baseUrl: process.env.BASE_URL || "http://localhost:8001",
    apiUrl: process.env.API_URL || "http://localhost:8001/api",
    jivoSiteUrl: process.env.JIVOSITE_URL || "http://localhost:8001"
  },

  /*
   ** Global CSS
   */
  css: [],
  /*
   ** Plugins to load before mounting the App
   ** https://nuxtjs.org/guide/plugins
   */
  plugins: [
    "~plugins/vue-js-modal.js",
    "~plugins/axios",
    "~plugins/plur-strings",
    { src: "~plugins/vue-countdown", mode: "client" },
    { src: "~plugins/vue-toast-notification", mode: "client" },
    { src: "~plugins/vue-jivosite", mode: "client" },
    { src: "~plugins/vue-loader-overlay", mode: "client" }
  ],
  /*
   ** Auto import components
   ** See https://nuxtjs.org/api/configuration-components
   */
  components: true,
  /*
   ** Nuxt.js dev-modules
   */
  buildModules: [
    // Doc: https://github.com/nuxt-community/eslint-module
    "@nuxtjs/fontawesome"
  ],
  /*
   ** Nuxt.js modules
   */
  modules: [
    // Doc: https://axios.nuxtjs.org/usage
    "@nuxtjs/axios",
    "@nuxtjs/auth"
  ],
  /*
   ** Axios module configuration
   ** See https://axios.nuxtjs.org/options
   */
  axios: {
    baseURL: process.env.API_URL || "http://be-in-top.loc/backend"
  },
  /*
   ** Build configuration
   ** See https://nuxtjs.org/api/configuration-build/
   */
  build: {
    splitChunks: {
      layouts: true
    }
  },

  auth: {
    strategies: {
      local: {
        endpoints: {
          login: { url: "/auth/login", method: "post", propertyName: "token" },
          logout: { url: "/auth/logout", method: "post" },
          user: { url: "/auth/user", method: "get", propertyName: "user" }
        },
        redirect_uri: "/userpanel"
        // tokenRequired: true,
        // tokenType: 'bearer',
        // globalToken: true,
        // autoFetchUser: true
      }
    },
    redirect: false
  },

  fontawesome: {
    icons: {
      solid: [
        "faCog",
        "faStar",
        "faTh",
        "faUser",
        "faUsers",
        "faLongArrowAltLeft",
        "faLongArrowAltRight",
        "faHeart",
        "faEye",
        "faHome",
        "faList",
        "faSignOutAlt",
        "faLink",
        "faTrashAlt"
      ]
    }
  }
};
