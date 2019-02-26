import VueRouter from 'vue-router';

let titleSuffix = ' - Time Sheet';

const routes = [
  {
    path: '/',
    component: require('./views/Home').default,
    meta: {
      title: 'Home',
      requiresAuth: true
    }
  },   
  {
    path: '/login',
    component: require('./views/Login').default,
    meta: {
      title: 'Login',
      requiresAuth: false
    }
  },
  {
    path: '/register',
    component: require('./views/Register').default,
    meta: {
      title: 'Register',
      requiresAuth: false
    }
  },
  {
    path: '/projects',
    component: require('./views/Projects').default,
    meta: {
      title: 'Projects',
      requiresAuth: true
    }
  },
  {
    path: '/projects/:id/:slug',
    component: require('./views/Project').default,
    meta: {
      title: 'Project',
      requiresAuth: true
    }
  },
  {
    path: '/tasks',
    component: require('./views/Tasks').default,
    meta: {
      title: 'Tasks',
      requiresAuth: true
    }
  },
  {
    path: '/*',
    component: require('./views/NotFound').default,
    meta: {
      title: 'Page Not Found',
      requiresAuth: false
    }
  }           
];

const router = new VueRouter({
  mode: 'history',
  linkActiveClass: 'active',
  routes  
});

router.beforeEach((to, from, next) => {
  // Update page title.
  document.title = to.meta.title + titleSuffix;

  // Check if route requires auth then check is user logged in.
  if (to.meta.requiresAuth && ! store.state.auth.isUserLoggedIn) {
    // if user not logged in then redirect to login.
    next('/login'); 
  }

  // Check if route is login or register.
  // if user logged in then restrict user to view login and register.
  if ((to.path == '/login' || to.path == '/register') && store.state.auth.isUserLoggedIn) {
    next('/');
  } 

  next();
});

export default router;
