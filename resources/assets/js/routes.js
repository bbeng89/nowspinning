import App from './App.vue'
import Home from './components/Home.vue'
import Test from './components/Test.vue'

export default [
    {
        path: '/app',
        component: App,
        children: [
            { path: '/', component: Home, name: 'home' },
            { path: 'test', component: Test, name: 'test' }
        ]
    }
]