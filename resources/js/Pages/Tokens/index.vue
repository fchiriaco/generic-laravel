<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>

        </template>
        <div class="jumbotron col-md-5 col-xs-12 mt-20 ml-10">
            <div class="font-semibold text-xl text-gray-800 leading-tight text-center">
                    Generazione Token
            </div>
            <div class="alert alert-info">Plain text dell'ultimo token generato: <b>{{lasttoken}}</b></div>
            <div class="mt-5 ml-10">
                <form class="row g-5" @submit.prevent="creatoken">
                        <div class="col-auto">
                            <input type="text"  class="form-control-plaintext" id="token_name" name="token_name" v-model="token_name" placeholder="Token Name" required>
                            <input type="hidden" name="_token" v-model="token" />

                        </div>

                        <div class="col-auto">
                            <input type="text"  class="form-control-plaintext" id="token_abilities" name="token_abilities" v-model="token_abilities" placeholder="Token ability" required>
                        </div>

                        <div class="col-auto">
                            <button  class="btn btn-primary mb-3" type="submit">Crea Token</button>
                        </div>

                </form>

            </div>
        </div>
        <div class="col-md-5 col-xs-12 ml-4">
        <Token @elimina-token="eliminaToken" :tokens="tokens"/>
        </div>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Token from '@/Pages/components/tokens/Tokens'
    export default {
        components: {
            AppLayout,
            Token


        },

        mounted(){

            window.axios.get('/listatokens').then((response) => {
                this.tokens = response.data;

            }).catch((e) => console.log(e));

        },
        data() {
            return {

                        token_name:'token',
                        token_abilities: '*',
                        tokens: [],
                        lasttoken: '',



                }
        },
        methods: {
                    creatoken(){

                            axios.post('/tokens/create',{'token_name': this.token_name,'token_abilities':[this.token_abilities]})
                            .then((response) => {

                                const tok = {'id':response.data[0].id ,'name':response.data[0].name,'token':response.data[0].token,'abilities':response.data[0].abilities};

                                this.tokens.push(tok);
                                this.lasttoken = response.data.ptext;

                            })
                            .catch((e) => console.log(e + ' Errore' ));

                            },
                    eliminaToken(id) {

                            this.tokens = this.tokens.filter( function(token){
                                        return token.id !== id });

                    }
        },
    }
</script>
