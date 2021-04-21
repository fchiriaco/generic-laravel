<template>
    <table class="table table-dark table-striped">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th v-for="label in labels" :key="label">{{label}}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="dataset in datasets" :key="dataset.label">
            <td>{{dataset.label}}</td>
            <td v-for="dato in dataset.data" :key="dato">{{dato}}</td>
        </tr>

        </tbody>
    </table>
</template>
<script>
    export default {
        name: 'TabellaDati',
        props: ['labels', 'datasets']
    }
</script>
