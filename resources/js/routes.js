import Home from './components/Home';
import Dashboard from './components/Dashboard';
import Login from './components/Login';
import NotFound from './components/NotFound';

export default {
    mode: 'history',
    routes: [
        {
            path: '*',
            component: NotFound,
        },
        {
            path: '/',
            component: Login,
            name: 'Login'
        },
        {
            path: '/dashboard',
            component: Dashboard,
            name: 'Dashboard',
            beforeEnter: (to, form, next) => {
                axios.get('/api/authenticated').then((response) => {
                    next()
                }).catch(() => {
                    return next({ name: 'Login'})
                });
            }
        },
    ]
}