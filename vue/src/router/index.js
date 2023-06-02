import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/admin/Dashboard.vue';
import SidebarLayout from '../components/SidebarLayout.vue';
import Roles from '../views/admin/Roles.vue';
import Users from '../views/admin/User.vue';
import ExpenseCategory from '../views/admin/ExpenseCategory.vue';
import Expenses from '../views/admin/Expenses.vue';
import Login from '../views/Login.vue';

const routes = [
  {
    path: '/login',
    name: 'Login ',
    component: Login
  },
  {
    path: '/',
    name: 'Dashboard ',
    component: Dashboard,
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
  {
    path: '/expensecategory',
    name: 'ExpenseCategory',
    component: ExpenseCategory
  },
  {
    path: '/expenses',
    name: 'Expenses',
    component: Expenses
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
