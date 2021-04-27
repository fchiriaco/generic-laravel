<template>
<app-layout>
    <div class="container mt-1">
        <template v-if="vistabella">
                <h1 class="alert alert-info text-center text-4xl font-bold">Gestione Ruoli</h1>
                <div class="row">
                    <div class="col-6 ml-2">
                        <button @click="create" class="btn btn-primary">INSERISCI RUOLO UTENTE <i class="fas fa-plus-square" style="font-size:1.6em;color:#ffffff;padding:3px;"></i></button>
                    </div>
                    <div class="col-5"><Search v-model="textsearch" @search="cerca"/></div>
                </div>
                
                <TableRecords @cancrec="delrec($event)" @modrec="modrecord($event)" :labels="labels" :dati="roles" :nomi_campi="nomi_campi" />
                <div v-if="mostra_navigazione" class="container  pt-2 pb-2 pl-1 bg-green-700">
                    <NavPages :links="links" />
                </div>
        </template>
        <template v-else>
            <CreateForm v-if="azione=='crea'" :action="'Creazione'" @back="vistabella = true"/>
            <CreateForm  v-else-if="azione=='modifica'" :roleform="roleform" :action="'Modifica'" @back="vistabella = true"/>
        </template>
    </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import TableRecords from '@/Pages/components/TableRecords';
    import NavPages from '@/Pages/components/NavPages';
    import Search from '@/Pages/components/Search';
    import CreateForm from '@/Pages/components/roles/CreateForm';
    export default {

        data() {
            return {
                roles: this.$attrs.roles.data,
                links: this.$attrs.roles.links,
                labels: ['Ruolo'],
                nomi_campi: ['rolename'],
                textsearch: '',
                vistabella:true,
                azione: "",
                roleform: {}
            
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
                        axios.delete(`/roles/${event}`)
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
                    let role = this.roles.filter(function(elem){
                        return elem.id == event;
                    })
                    
                    this.roleform = {
                                    id:role[0].id,
                                    rolename: role[0].rolename,
                                    
                                };
                    
                   
                },
                cerca(){
                        axios.get(`/rolessearch/${this.textsearch}`)
                        .then((response) => {
                            this.roles = response.data.data;
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