<template>
    
</template>

<script>
    import $ from 'jquery';
    import axios from 'axios';
    import router from '../router'

    //axios.defaults.baseURL = 'http://owode-api.bj/api/v1';

    export default {
        name:"Payment_Paydunya",
        data: function (){
            return{
                transaction:'',
                errors : []
            }
        },
        created() {
            this.payWithPaydunya(this)
        },
        methods : {
            payWithPaydunya(btn) {
                let transaction = this.$route.params.id
                PayDunya.setup({
                    selector: $(btn),
                    url: "http://testowodegateway.mydko-sarl.compay/dunya.php/"+this.$route.params.id+"/?token="+this.$route.params.token,
                    method: "GET",
                    displayMode: PayDunya.DISPLAY_IN_POPUP,
                    beforeRequest: function() {
                        console.log("About to get a token and the url");
                    },
                    onSuccess: function(token) {
                        console.log("Token: " +  token);
                    },
                    onTerminate: function(ref, token, status) {
                        console.log(ref);
                        console.log(token);
                        console.log(status);
                        setTimeout(function(){
                            console.log(token)
                            axios.get('https://app.paydunya.com/sandbox-api/v1/checkout-invoice/confirm/'+token,{
                                        headers: {
                                            'PAYDUNYA-MASTER-KEY': 'KeNaNWkz-TILV-N4MG-buyH-Mc4fkE9Y54Fc', 
                                            'PAYDUNYA-PRIVATE-KEY': 'live_private_xACzzgzZGr3aFlCbJbEbWSzmo5x', 
                                            'PAYDUNYA-TOKEN': '2TWzJ13pGOBvBfLS3l8i'
                                        }
                                }).then(function (response) {
                                    console.log(JSON.stringify(response.data));
                                    if(response.data.status === 'completed'){
                                        let stat = 'Success'
                                        axios.post('http://testowodeapi.mydko-sarl.com/api/v1/transactions/paymentStatus',{transaction:transaction,statut:stat}).then(function (data) {
                                                if(data.erroMessage == 'Success'){
                                                        router.push('/success')
                                                }
                                            })
                                    }

                                    if(response.data.status === 'failed' || status === 'cancelled'){
                                        let stat = 'Blocked'
                                        axios.post('http://testowodeapi.mydko-sarl.com/api/v1/transactions/paymentStatus',{transaction:transaction,statut:stat}).then(function (data) {
                                            if(data.erroMessage == 'Success'){
                                                router.push('/echec')
                                         }
                                        })
                                    }
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                            
                        },7000,token);
                    },
                    onError: function (error) {
                        alert("Unknown Error ==> ", error.toString());
                    },
                    onUnsuccessfulResponse: function (jsonResponse) {
                        console.log("Unsuccessful response ==> " + jsonResponse);
                    },
                    onClose: function() {
                        console.log("Close");
                    }
                }).requestToken();
            }

        }
    }

</script>

<style scoped>

</style>