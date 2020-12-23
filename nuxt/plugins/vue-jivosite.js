import Vue from 'vue'


function initChat() {
    let s1 = document.createElement("script");
    let s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = process.env.jivoSiteUrl;
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
}

Vue.mixin({
    beforeRouteEnter (to, from, next) {
        next(vm => {
            if(process.client && !window.jivo_api && (!vm.$auth.$state.loggedIn || vm.$auth.$state.user.usertype === 'user')) {
                initChat();

                window.jivo_onLoadCallback = () => {
                    if(vm.$auth.$state.loggedIn) {
                        jivo_api.setContactInfo({
                            name: vm.$auth.$state.user.full_name,
                            phone: vm.$auth.$state.user.phone,
                        });
                    }
                }
            }
        })
    }
})