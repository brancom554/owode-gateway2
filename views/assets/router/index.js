import Vue from 'vue'
import VueRouter from 'vue-router'

import Payment from '../Composents/Payment'
import Payment2 from '../Composents/Payments'
import Success from '../Composents/Success'
import Echec from '../Composents/Echec'

Vue.use(VueRouter)


const routes = [
    {
        path: '/payment.php/:id/:token',
        name:'App_2',
        component: Payment2,
    },
    {
        path: '/gateway.php/:id/:token',
        name:'App_gateway',
        component: Payment,
    },
    {
        path: '/payment.php/success',
        name:'App_3',
        component: Success,
    },
    {
        path: '/payment.php/echec',
        name:'App_4',
        component: Echec,
    },
    {
        path: '/gateway.php/:id/echec',
        name:'App_Echec',
        component: Echec,
    },
    {
        path: '/gateway.php/:id/success',
        name:'App_Success',
        component: Success,
    }
]

const router = new VueRouter({
    mode: 'history',
    routes 
  })

export default router;