import { createRouter, createWebHistory } from 'vue-router'
import Users from '../views/Users.vue'
import Orders from '../views/Orders.vue'
import Login from '../components/Login.vue'
import UserForm from '../components/UserForm.vue'
import OrderForm from '../components/OrderForm.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: Login
    },
    {
      path: '/users',
      name: 'Users',
      component: Users
    },
        {
      path: '/orders',
      name: 'orders',
      component: Orders
    },
    { path: '/edit-user/:id', component: UserForm },
    { path: '/edit-order/:id', component: OrderForm },
    { path: '/create-user/', component: UserForm },
    { path: '/create-order/', component: OrderForm },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    }
  ]
})

export default router
