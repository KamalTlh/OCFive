import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
import Home from '../views/Home.vue'
import AdminView from '../views/AdminView.vue'
import UserProfile from '../views/UserProfile.vue'
import ResearchWorkers from '../views/ResearchWorkers.vue'
import WorkerDetailView from '../views/WorkerDetailView.vue'
import Register from '../views/Register.vue'


Vue.use(VueRouter)

  const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/adminview',
    name: 'AdminView',
    component: AdminView,
    // a meta field
    meta: { requiresAuth: true }
  },
  {
  path: '/userprofile',
  name: 'UserProfile',
  component: UserProfile,
  // a meta field
  meta: { requiresAuth: true }
  },
  {
    path: '/researchworkers',
    name: 'ResearchWorkers',
    component: ResearchWorkers
  },
  {
    path: '/workerdetailview',
    name: 'WorkerDetailView',
    component: WorkerDetailView
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!store.state.sessionConnected) {
      next({
        path: '/',
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})
export default router
