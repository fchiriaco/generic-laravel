<template>
<app-layout>
    <div class="container mt-1">
        <template v-if="vistabella">
                <h1 class="alert alert-info text-center text-4xl font-bold">Gestione Utenti</h1>
                <div class="row">
                    <div class="col-6 ml-2">
                        <button @click="create" class="btn btn-primary">INSERISCI UTENTE <i class="fas fa-plus-square" style="font-size:1.6em;color:#ffffff;padding:3px;"></i></button>
                    </div>
                    <div class="col-5"><Search v-model="textsearch" @search="cerca"/></div>
                </div>
                
                <TableRecords @cancrec="delrec($event)" @modrec="modrecord($event)" :labels="labels" :dati="users" :nomi_campi="nomi_campi" />
                <div v-if="mostra_navigazione" class="container  pt-2 pb-2 pl-1 bg-green-700">
                    <NavPages :links="links" />
                </div>
        </template>
        <template v-else>
            <CreateForm v-if="azione=='crea'" :roles="roles" :action="'Creazione'" @back="vistabella = true"/>
            <CreateForm  v-else-if="azione=='modifica'" :utenteform="utenteform" :roles="roles" :action="'Modifica'" @back="vistabella = true"/>
        </template>
    </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import TableRecords from '@/Pages/components/TableRecords';
    import NavPages from '@/Pages/components/NavPages';
    import Search from '@/Pages/components/Search';
    import CreateForm from '@/Pages/components/users/CreateForm';
    export default {

        data() {
            return {
                users: this.$attrs.users.data,
                links: this.$attrs.users.links,
                roles: this.$attrs.roles,
                labels: ['Cognome','Nome','Email'],
                nomi_campi: ['lastname','name','email'],
                textsearch: '',
                vistabella:true,
                azione: "",
                utenteform: {}
            
            }
        },
        components: {
                AppLayout,
                TableRecords,
                NavPages,
                Search,
                CreateForm
            },
        Computed: {
            mostra_navigazione() {
                if (this.links[0].url !== null || this.links[this.links.length -1].url !== null)
                    return true;
                else
                    return false;

            },
            
        },
        watch: {
            vistabella: function (newvalue,oldvalue) {
                    if(newvalue == true && oldvalue == false)
                    {
                        this.cerca();
                    }
            }
        },
        methods: {

                delrec(event)
                {
                    let conf = confirm('Sei sicuro di voler cancellare il record?')
                    if(conf)
                    {   
                        axios.delete(`/users/${event}`)
                        .then((response) => {
                            this.cerca();
                        }).catch((e) => {
                            alert('errore durante la cancellazione');
                        })
                    }
                },
                modrecord(event) {
                    this.azione = "modifica";
                    this.vistabella = false;
                    let user = this.users.filter(function(elem){
                        return elem.id == event;
                    })
                    
                    this.utenteform = {
                                    id:user[0].id,
                                    lastname: user[0].lastname,
                                    name: user[0].name,
                                    email: user[0].email,
                                    birth: user[0].birth,
                                    natoa:user[0].natoa,
                                    address: user[0].address,
                                    city: user[0].city,
                                    cap: user[0].cap,
                                    phone:user[0].phonr,
                                    cfiscale: user[0].cfiscale,
                                    prov: user[0].prov,
                                    password: '',
                                    password_confirmation: '',
                                    role_id: user[0].roles[0].id
                                };
                    
                   
                },
                cerca(){
                        axios.get(`/userssearch/${this.textsearch}`)
                        .then((response) => {
                            this.users = response.data.data;
                            this.links = response.data.links;
                        })
                        .catch((e) => {
                            
                            alert('Errore nel database')} );
                },
                create()
                {
                     this.azione = "crea";
                    this.vistabella = false;
                   
                },
                
            }
        
    }
</script>

<style lang="scss" scoped>

</style>