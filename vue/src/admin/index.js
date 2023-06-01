import {createStore} from "vuex";

const admin = createStore({
    state: {
        user: {
            data: {name: 'Jhon Carlos'},
            token: null
        }
    },
    getters: {},
    actions: {},
    mutations: {},
    modules: {}
})

export default admin