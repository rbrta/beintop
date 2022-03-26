export const state = () => ({
    orders: []
})

export const mutations = {
    SET_ORDERS (state, orders) {
        state.orders = orders;
    }
}

export const actions  = {
    async getOrders ({ commit, state }) {
        if(!state.orders.length > 0) {
            const data = await this.$axios.$get('/user/orders');
            commit('SET_ORDERS', data);
        }
    }
}