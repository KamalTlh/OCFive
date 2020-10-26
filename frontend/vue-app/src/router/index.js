import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
import Home from '../views/Home.vue'
import AdminView from '../views/AdminView.vue'
import UserProfile from '../views/UserProfile.vue'
import UserUpdate from '../views/UserUpdate.vue'
import UpdatePasswordView from '../views/UpdatePasswordView.vue'
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
    path: '/updatepassword',
    name: 'UpdatePasswordView',
    component: UpdatePasswordView,
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
    component: Register,
    meta: { requiresLogout: true }
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
    window.scroll(0,0);
    next() // make sure to always call next()!
  }
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  const tokenExpiration = localStorage.getItem('expiration');
  const d = new Date();
  const currentDate = parseInt(d.getTime() / 1000); // Date actuelle en secondes.
  const ifExpirate = tokenExpiration - currentDate;
  if (token && token != '' && ifExpirate > 0) {
      store.commit("changeSessionState", true );
      const localUser = localStorage.getItem('user');
      if (localUser) {
        const user = JSON.parse(localUser);
        store.commit("setUserLogged", user );
      }
    next()
  } else {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    localStorage.removeItem('expiration');
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

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresLogoutOrAdmin)) {
    // this route requires admin access, check if user have access
    // if not, redirect to home page.
    const token = localStorage.getItem('token');
    const localUser = localStorage.getItem('user');
      if (token || localUser) {
          const user = JSON.parse(localUser);
          if (user.role_id != 1) {
            next({
              path: '/',
              query: { redirect: to.fullPath }
            })
          } else {
            next()
          }
      } else {
        next()
      }
  }
  else {
    next()
  }
})

export default router
