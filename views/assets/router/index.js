import Vue from 'vue'
import VueRouter from 'vue-router'

import Payment from '../Composents/Payment'
import Success from '../Composents/Success'
import Echec from '../Composents/Echec'

Vue.use(VueRouter)


const routes = [
    {
        path: '/payment.php/:id/:token',
        name:'App_2',
        component: Payment,
    },
    {
        path: '/success',
        name:'App_3',
        component: Success,
    },
    {
        path: '/echec',
        name:'App_4',
        component: Echec,
    }
]

const router = new VueRouter({
    mode: 'history',
    routes 
  })

export default router;