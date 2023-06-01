import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/admin/Dashboard.vue';
import SidebarLayout from '../components/SidebarLayout.vue';
import Roles from '../views/admin/Roles.vue';
import Users from '../views/admin/User.vue';
import Login from '../views/Login.vue';

const routes = [
  {
    path: '/login',
    name: 'Login ',
    component: Login
  },
  {
    path: '/',
    redirect: '/dashboard',
    // name: 'Dashboard ',
    component: SidebarLayout,
    children: [
      {path: '/dashboard', name: 'Dashboard', component: Dashboard}
    ]
  },
  {
    path: '/roles',
    name: 'Roles',
    component: Roles
  },
  {
    path: '/user',
    name: 'Users',
    component: Users
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
