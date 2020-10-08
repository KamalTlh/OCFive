import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: {},
    userLogged: {},
    markers: {},
    workers: {},
    healthworkerId: null,
    sessionConnected: false,
    isAuthenticated: false
  },
  mutations: {
    changeUser (state, payload ){
      state.user = payload
    },
    setUserLogged(state, payload){
      state.userLogged = payload
    },
    changeWorker(state, workerId ){
      state.healthworkerId = workerId
    },
    changeSessionState (state, sessionstate ){
      state.sessionConnected = sessionstate
    },
    setWorkers(state, payload){
      state.workers = payload
    },
    setMarkers(state, payload){
      state.markers = payload
    },
    isAuthenticated (state, payload) {
      state.isAuthenticated = payload.isAuthenticated
    }
  },
  actions: {
  },
  modules: {
  },
  getters: {
    getCurrentUser(state){
      return state.userLogged
    },
    getUserToUpdate(state){
      return state.user
    },
    getMarkers(state){
      return state.markers
    }
  }
})
