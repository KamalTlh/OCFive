import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
import Home from '../views/Home.vue'
import AdminView from '../views/AdminView.vue'
import UserProfile from '../views/UserProfile.vue'
import UserUpdate from '../views/UserUpdate.vue'
import PasswordUpdate from '../views/PasswordUpdate.vue'
import ResearchWorkers from '../views/ResearchWorkers.vue'
import WorkerDetailView from '../views/WorkerDetailView.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Error404 from '../views/Error404.vue'
import Error500 from '../views/Error500.vue'




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
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
  path: '/userprofile',
  name: 'UserProfile',
  component: UserProfile,
  // a meta field
  meta: { requiresAuth: true }
  },
  {
    path: '/userupdate',
    name: 'UserUpdate',
    component: UserUpdate,
    // a meta field
    meta: { requiresAuth: true }
  },
  {
    path: '/passwordupdate',
    name: 'PasswordUpdate',
    component: PasswordUpdate,
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
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },
  {
    path: '/error404',
    name: 'Error404',
    component: Error404
  },
  {
    path: '/error500',
    name: 'Error500',
    component: Error500
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach((to, from, next) => {
  if (!to.matched.length) {
    // check if the path matches any route before navigation 
    // if not, redirect to the Not found page.{
    next({
      path: '/error404',
      query: { redirect: to.fullPath },
    })
  } else {
    next() // make sure to always call next()!
  }
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  if (token) {
      store.commit("changeSessionState", true );
      const localUser = localStorage.getItem('user');
      if (localUser) {
        const user = JSON.parse(localUser);
        store.commit("setUserLogged", user );
      }
    next()
  } else {
    store.commit("changeSessionState", false );
    next() // make sure to always call next()!
  }
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    const token = localStorage.getItem('token');
    if (!token) {
      store.commit("changeSessionState", false );
      next({
        path: '/login',
        query: { redirect: to.fullPath },
      })
    } else {
      const localUser = localStorage.getItem('user');
      if (localUser) {
        const user = JSON.parse(localUser);
        store.commit("setUserLogged", user );
        store.commit("changeSessionState", true );
        if (from.fullPath != '/adminview'){
          store.commit("changeUser", user );
        }
      }
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAdmin)) {
    // this route requires admin access, check if user have access
    // if not, redirect to home page.
    const localUser = localStorage.getItem('user');
      if (localUser) {
        const user = JSON.parse(localUser);
        if (user.role_id != 1) {
          next({
            path: '/',
            query: { redirect: to.fullPath }
          })
        } else {
          next()
        }
    }
  } else {
    next() // make sure to always call next()!
  }
})
export default router
