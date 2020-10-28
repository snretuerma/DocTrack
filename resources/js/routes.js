import Dashboard from './components/user/Dashboard';
import DocumentRecords from './components/user/DocumentRecords';
import Reports from './components/user/Reports';
import AccountSettings from './components/user/AccountSettings';

import NewDocument from './components/user/NewDocument';
import DocumentAction from './components/user/DocumentAction';
import ReportAging from './components/user/ReportAging';
import ReportMasterList from './components/user/ReportMasterList';

import Login from './components/Login';
import HomeContainer from './components/HomeContainer';
import NotFound from './components/NotFound';

// TODO: Fix routes structure
export default {
    base: '/api',
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
            path: '/',
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
                    path: 'account_settings',
                    component: AccountSettings,
                    name: 'Account Settings'
                },
                {
                    path: 'new_document',
                    component: NewDocument,
                    name: 'New Document'
                },
                {
                    path: 'receive_document/:routing_number',
                    component: DocumentAction,
                    name: 'Receive Document'
                },
                {
                    path: 'forward_document/:routing_number',
                    component: DocumentAction,
                    name: 'Forward Document'
                },
                {
                    path: 'terminal_document/:routing_number',
                    component: DocumentAction,
                    name: 'Terminal Document'
                },
                {
                    path: 'reports/aging',
                    component: ReportAging,
                    name: 'Document Aging Report'
                },
                {
                    path: 'reports/master_list',
                    component: ReportMasterList,
                    name: 'Document Master List'
                }
            ]
        },

    ]
}