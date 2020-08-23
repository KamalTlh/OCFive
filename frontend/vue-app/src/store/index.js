import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: {},
    userLogged: {},
    healthworkerId: null,
    sessionConnected: false
  },
  mutations: {
    changeUser (state, payload ){
      state.user = payload
    },
    setUserLogged(state, payload){
      state.userLogged = payload
    },
    changeWorker (state, workerId ){
      state.healthworkerId = workerId
    },
    changeSessionState (state, sessionstate ){
      state.sessionConnected = sessionstate
    }
  },
  actions: {
  },
  modules: {
  }
})
