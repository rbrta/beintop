import Vue from 'vue'

function initTawkChat() {
    if (window.Tawk_API) {
        return true
    }

    let Tawk_API = {}
    let Tawk_LoadStart = new Date()
    let s1 = document.createElement("script")
    let s0 = document.getElementsByTagName("script")[0]
    s1.async = true
    s1.src = 'https://embed.tawk.to/5fc4dc5ea1d54c18d8eecb37/default'
    s1.charset = 'UTF-8'
    s1.setAttribute('crossorigin', '*')
    s0.parentNode.insertBefore(s1, s0)
    window.Tawk_API = Tawk_API
}

Vue.mixin({
    beforeRouteEnter (to, from, next) {
        next(vm => {
            if(process.client && (!vm.$auth.$state.loggedIn || vm.$auth.$state.user.usertype === 'user')) {
                initTawkChat();
            }
        })
    }
})