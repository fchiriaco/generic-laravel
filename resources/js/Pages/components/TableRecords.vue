<template>
    
    <table class="table">
        <thead>
        <tr>
            <th v-for="label in labels" :key="label">{{label}}</th>
            <th>Modifica</th>
            <th>Cancella</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="(row, index) in dati" :key="index">
                <td v-for="(nome_campo,idx) in nomi_campi" :key="row[nome_campo_per_key] + idx">
                           {{row[nome_campo]}}
                </td>
                
                <td>
                    <button  v-on:click="modrecord(row[nome_campo_per_key])" class="btn btn-success"><i class="fas fa-edit"></i></button>
                </td>
                <td>
                    <button  v-on:click="delrecord(row[nome_campo_per_key])" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
    export default {
        name: 'TableRecords',
        props:{
                labels: {
                            type:Array,
                            required: true,
                        },   
                        dati: {
                            type:Array,
                            required: true,
                        },  
                        nomi_campi: {
                            type:Array,
                            required: true,
                        },
                        nome_campo_per_key: {
                            type: String,
                            default: 'id'
                        }    
        },
        emits:['cancrec','modrec'],
        methods: {
                delrecord(id) {
                        this.$emit('cancrec',id);
                },
                modrecord(id) {
                        this.$emit('modrec',id);
                }

        }
        
    }
</script>
