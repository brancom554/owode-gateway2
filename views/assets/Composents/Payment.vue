<template>
    
</template>

<script>
    import $ from 'jquery';
    import axios from 'axios';

    axios.defaults.baseURL = 'http://testowodeapi.mydko-sarl.com/api/v1';

    export default {
        name:"Payment_Paydunya",
        created() {
            this.payWithPaydunya(this)
        },
        methods : {
            payWithPaydunya(btn) {

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
                        if(status == 'completed'){
                            let stat = 'Success'
                            axios.post('/transaction/paymentStatus',{transaction:this.$route.params.id,statut:stat}).then(function (data) {
                                        if(data.erroMessage == 'Success'){
                                            this.$route.push('/success')
                                        }
                                    })
                        }

                        if(status == 'failed' || status == 'cancelled'){
                            let stat = 'Blocked'
                            axios.post('/transaction/paymentStatus',{transaction:this.$route.params.id,statut:stat}).then(function (data) {
                                        if(data.erroMessage == 'Success'){
                                            this.$route.push('/echec')
                                        }
                                    })
                        }
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