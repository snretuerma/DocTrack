import Dashboard from './components/user/Dashboard';
import DocumentRecords from './components/user/DocumentRecords';
import Reports from './components/user/Reports';
import AccountSettings from './components/user/AccountSettings';

import Login from './components/Login';
import HomeContainer from './components/HomeContainer';
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
            name: 'Login',
        },
        {
            path: '/user',
            component: HomeContainer,
            beforeEnter: (to, form, next) => {
                axios.get('/api/authenticated').then((response) => {
                    next()
                }).catch(() => {
                    return next({ name: 'Login'})
                });
            },
            children: [
                {
                  path: '/',
                  component: Dashboard,
                  name: 'Dashboard',
                },
                {
                  path: 'document_records',
                  component: DocumentRecords,
                  name: 'Document Records',
                },
                {
                    path: 'reports',
                    component: Reports,
                    name: 'Reports',
                },
                {
                    path: 'account_settings',
                    component: AccountSettings,
                    name: 'Account Settings',
                }
              ]
        },

    ]
}