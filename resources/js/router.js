import { createRouter, createWebHistory } from 'vue-router'

import Home from './components/Home.vue'
import Layout from './frontend/Layout.vue'
import Index from './frontend/Index.vue'
// import Posts from './components/Posts.vue'
// import Blogs from './components/Blogs.vue'
// import TodoApp from './components/todo/TodoApp.vue'
// import CheckListApp from './components/checkList/CheckListApp.vue'
// import MyToDo from './components/mytodo/MyToDo.vue'
// import Camp from './components/Camp.vue'
// import Login from './components/Login.vue' // Import the Login component
// import Count from './components/Count.vue'
// import ToDo from './components/practice/todo.vue'
    
const routes = [
    { path: '/', name: 'Index', component: Index },
    // { path: '/login', name: 'Login', component: Login },
    // { path: '/', redirect: '/posts', meta: { requiresAuth: true } }, // default
    // { path: '/posts', name: 'Posts', component: Posts  ,meta: { requiresAuth: true }},
    // { path: '/camps', name: 'Camps', component: Camp  ,meta: { requiresAuth: true }},
    // { path: '/blogs', name: 'Blogs', component: Blogs  ,meta: { requiresAuth: true }},
    // { path: '/todos', name: 'Todos', component: TodoApp  ,meta: { requiresAuth: true }},
    // { path: '/checklist', name: 'CheckList', component: CheckListApp  ,meta: { requiresAuth: true }},
    // { path : '/mytodolist', name: 'mytodolist', component: MyToDo ,meta: { requiresAuth: true }},
    // { path : '/new-blogs', name: 'NewBlogs', component: Blogs , meta: {requiresAuth: true}},
    // { path : '/count', name: 'Count', component:Count},
    // { path : '/todo', name: 'Todo', component:ToDo },
    // { path : '/products', name: 'Products', component: () => import('./ProductForm.vue'), meta: { requiresAuth: false }}
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('token');
    console.log(loggedIn);
    if (to.name === 'Login' && loggedIn) {
        next({ name: 'Posts' });
    }
    else if (to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
        console.log(to.matched);
        next('/login');
    } else {
        console.log('no');
        next();
    }
});

export default router
