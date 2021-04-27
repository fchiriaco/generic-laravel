<template>
    <h1 class="alert alert-info text-center text-4xl"><strong>{{action}} ruolo</strong></h1>
        <jet-validation-errors class="mb-4" />

        <form id="formcreate" @submit.prevent="submit">
            <div class="row">
                <div class="col-xs-12 col-md-6 ml-4">
                    <jet-label for="rolename" value="Ruolo *" />
                    <jet-input id="rolename" type="text" class="mt-1 block w-full" v-model="form.rolename" required autofocus autocomplete="rolename" />
                </div>
                <!-- col-6 disponibile -->
            </div>
            <div class="row mt-3">
                <div class="col-xs-12 col-md-3 bg-gray-500 text-center p-3 m-3">
                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        SALVA RECORD
                    </jet-button>
                </div>
                <div class="col-xs-12 col-md-3 bg-gray-500 text-center p-3 m-3">
                    <jet-button class="btn btn-success" @click.prevent="$emit('back')">VEDI ELENCO</jet-button>
                </div>
                <div class="col-xs-12 col-md-6"></div>
            </div>
        </form>
        <div  v-if="salvataggiook" class="alert alert-success text-center text-2xl">
            <strong>Dati salvati con successo</strong>
            <p class="text-right mt-0 pt-0">
                <button  @click.prevent="salvataggiook=false" type="button" class="btn btn-primary">Chiudi</button>
            </p>
         </div>

        <div  v-if="salvataggioko" class="alert alert-danger text-center text-2xl">
            <strong>Errore nei dati!!! {{errore}}</strong>
            <p class="text-right mt-0 pt-0">
                <button  @click.prevent="salvataggioko=false" type="button" class="btn btn-primary">Chiudi</button>
            </p>
        </div>
</template>

<script>
    import axios from 'axios';
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard';
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo';
    import JetButton from '@/Jetstream/Button';
    import JetInput from '@/Jetstream/Input';
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label';
    import JetValidationErrors from '@/Jetstream/ValidationErrors';
    

    export default {
        name:'CreateForm',
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },
        props:{
            
                roleform: {
                            type: Object,
                            default: function(){ 
                                
                                                return  {
                                                            id:0,
                                                            rolename: ''
                                                        }
                                                }
                            
                            },
                action: {
                            type:String,
                            required: true,
                            default: "Creazione"
                        }
            },
        data() {
                    return {
                                
                                salvataggiook: false,
                                salvataggioko: false,
                                form: this.roleform
                                
                            }
        
                },
                methods: {

                            submit() {
                                       
                                        if(this.action == "Creazione")
                                        {
                                            axios.post(this.route('roles.store'),this.form)
                                            .then((response) => {
                                                this.salvataggiook = true;
                                                this.salvataggioko = false;
                                                this.resetFields();
                                            })
                                            .catch ((e) => { 
                                                    this.salvataggioko = true;
                                                    this.salvataggiook = false;
                                                }); 
                                        }
                                        else
                                        {
                                            axios.put(`roles/${this.form.id}`,this.form)
                                            .then((response) => {
                                                this.salvataggiook = true;
                                                this.salvataggioko = false;
                                                
                                            })
                                            .catch ((e) => { 
                                                    this.salvataggioko = true;
                                                    this.salvataggiook = false;
                                                    
                                                }); 

                                        }


                                       
                                       
                                    },

                            resetFields() {
                                this.form = {
                                    "id":0,
                                    "rolename": '',
                                } 
                            
                        }
                    }
    }
</script>

<style lang="scss" scoped>

</style>