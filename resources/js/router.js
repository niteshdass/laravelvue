import Vue from 'vue';
import VueRouter from 'vue-router'
import LoginComponent from './components/LoginComponent'
import AdminComponent from './components/AdminComponent'
import RulesComponent from './components/RulesComponent'
import UserComponent from './components/UserComponent'

Vue.use(VueRouter)

const routes = [
      {
            path: '/',
            redirect:'/login',
      },
      {
            path: '/login',
            component: LoginComponent,
            name:'Login'
      },

 
       {
            path: '/users',
            component: UserComponent,
            name:"users"
       },           
           

      {
            path: '/admin',
            component: AdminComponent,
            name: 'Admin',
             
            children: [
                  {
                        path: '/rules',
                        component: RulesComponent,
                        name:"rules"
                  }
            ],
            
            beforeEnter: (to, from, next) => {
                 axios.get('/api/verify')
                 .then( res => next() )
                 .catch( err => next('/login'))
            }
      }

]
const router = new VueRouter({ routes })
router.beforeEach((to, from, next) => {
      const token = localStorage.getItem('token' || null);
      window.axios.defaults.headers['Authorization'] = "Bearer " + token;
      next();
})


export default router