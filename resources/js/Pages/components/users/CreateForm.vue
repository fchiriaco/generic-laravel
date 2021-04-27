<template>
    <h1 class="alert alert-info text-center text-4xl"><strong>{{action}} utente</strong></h1>
        <jet-validation-errors class="mb-4" />

        <form id="formcreate" @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <jet-label for="lastname" value="Cognome *" />
                <jet-input id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" required autofocus autocomplete="lastname" />
            </div>
            <div class="col-xs-12 col-md-6">
                <jet-label for="name" value="Nome *" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" />
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-xs-12 col-md-3">
                <jet-label for="birth" value="Data di nascita" />
                <jet-input id="birth" type="date" class="mt-1 block w-full" v-model="form.birth"  />
            </div>

            <div class="col-xs-12 col-md-5">
                <jet-label for="natoa" value="Luogo nascita" />
                <jet-input id="natoa" type="text" class="mt-1 block w-full" v-model="form.natoa" />
            </div>
        
            <div class="col-xs-12 col-md-4">
                <jet-label for="cfiscale" value="P.Iva/C. Fiscale" />
                <jet-input id="cfiscale" type="text" class="mt-1 block w-full" v-model="form.cfiscale" />
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-xs-12 col-md-3">
                <jet-label for="email" value="Email *" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="col-xs-12 col-md-3">
                <jet-label for="phone" value="Telefono" />
                <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
            </div>
            <div class="col-xs-12 col-md-6">
                <jet-label for="address" value="Indirizzo" />
                <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xs-12 col-md-3">
                <jet-label for="cap" value="C.A.P" />
                <jet-input id="cap" type="text" class="mt-1 block w-full" v-model="form.cap" />
            </div>

            <div class="col-xs-12 col-md-6">
                <jet-label for="city" value="Città" />
                <jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" />
            </div>

            <div class="col-xs-12 col-md-3">
                <jet-label for="prov" value="Provincia" />
                <jet-input id="prov" type="text" class="mt-1 block w-full" v-model="form.prov" />
            </div>
        </div>

            <div class="mt-4">
                <jet-label for="password" value="Password *" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password"  :required="action == 'Creazione'" autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="Confirm Password *" />
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full"  v-model="form.password_confirmation"  :required="action == 'Creazione'" autocomplete="new-password" />
            </div>

            <div class="form-group row mt-4">
                <div class="col-md-4">
                    <jet-label for="role_id" value="Ruolo utente *" />
                    <select class="form-control" id="role_id" name="role_id" v-model.number="form.role_id" required>
                        <option v-for="role in roles" :key="role.id" :value="role.id" :selected="roleid == role.id">{{role.rolename}}</option>
                    </select>
                </div>

            </div>


            <div class="flex items-center mt-4">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    SALVA RECORD
                </jet-button>

                <jet-button class="btn btn-success" @click.prevent="$emit('back')">VEDI ELENCO</jet-button>
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
            roles: {
                type: Object,
                required: true
            },
            utenteform: {
                type: Object,
                default:      function() { return {
                                    id:0,
                                    lastname: '',
                                    name: '',
                                    cfiscale: '',
                                    email: '',
                                    birth: '',
                                    natoa:'',
                                    address: '',
                                    city: '',
                                    cap: '',
                                    phone:'',
                                    prov: '',
                                    password: '',
                                    password_confirmation: '',
                                    role_id:2
                                }}
                
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
                                form: this.utenteform
                                
                            }
        
                },
                methods: {

                            submit() {
                                       
                                        if(this.action == "Creazione")
                                        {
                                            axios.post(this.route('users.store'),this.form)
                                            .then((response) => {
                                                this.salvataggiook = true;
                                                this.salvataggioko = false;
                                                this.resetFields();
                                            })
                                            .catch ((e) => { 
                                                    this.salvataggioko = true;
                                                    this.salvataggiook = false;
                                                    console.log(e);
                                                    
                                                }); 
                                        }
                                        else
                                        {
                                            axios.put(`users/${this.form.id}`,this.form)
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
                                    "lastname": '',
                                    "name": '',
                                    "email": '',
                                    "birth": '',
                                    "natoa":'',
                                    "address": '',
                                    "city": '',
                                    "cap": '',
                                    "phone":'',
                                    "cfiscale": '',
                                    "prov": '',
                                    "password": '',
                                    "password_confirmation": '',
                                    "role_id":2
                                } 
                            
                        }
                    }
    }
</script>

<style lang="scss" scoped>

</style>