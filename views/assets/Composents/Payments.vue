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
                    url: "http://testowodegateway.mydko-sarl.com/paydunya.php/"+this.$route.params.id+"/?token="+this.$route.params.token,
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
                            axios.get('https://app.paydunya.com/api/v1/checkout-invoice/confirm/'+token,{
                                        headers: {
                                            'PAYDUNYA-MASTER-KEY': 'KeNaNWkz-TILV-N4MG-buyH-Mc4fkE9Y54Fc', 
                                            'PAYDUNYA-PRIVATE-KEY': 'live_private_xACzzgzZGr3aFlCbJbEbWSzmo5x', 
                                            'PAYDUNYA-TOKEN': '2TWzJ13pGOBvBfLS3l8i'
                                        }
                                }).then(function (response) {
                                    console.log(JSON.stringify(response.data));
                                    if(response.data.status === 'completed'){
                                        let stat = 'Success'
                                        axios.post('http://testowodegateway.mydko-sarl.com/paydunya.php',{
                                            transactions:transaction,statuts:stat}/*,{
                                                headers: {
                                                    'Access-Control-Allow-Origin': '*',
                                                    'Content-Type': 'application/json',
                                                }
                                            }*/).then(function (data) {
                                                if(data.data.data.errorMessage == 'Success'){
                                                    $('.vbox-overlay').addClass('d-none')
                                                        /*router.push('/payment.php/success')*/
                                                        window.location.assign('http://testowodegateway.mydko-sarl.com/payment.php/success');
                                                }
                                            })
                                    }

                                    if(response.data.status === 'failed' || response.data.status === 'cancelled' || response.data.status === 'pending'){
                                        let stat = 'Blocked'
                                        axios.post('http://testowodegateway.mydko-sarl.com/paydunya.php',{transactions:transaction,statuts:stat}).then(function (data) {
                                            //console.log(data.data.data.errorMessage)
                                            if(data.data.data.errorMessage == 'Blocked'){
                                                $('.vbox-overlay').addClass('d-none')
                                                /*router.push('/payment.php/echec')*/
                                                window.location.assign('http://testowodegateway.mydko-sarl.com/payment.php/echec')
                                         }
                                        })
                                    }
                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                            
                        },60000,token);
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