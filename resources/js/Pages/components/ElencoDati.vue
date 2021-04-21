<template>
    <table class="table text-white">
        <thead>
        <tr>
            <th v-for="label in labels" :key="label">{{label}}</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="(dato, index) in dati" :key="index">

                <td v-for="(item,name) in dato" :key="item">
                    <template v-if="name == 'link'">
                        <a class="btn btn-success text-2xl" :href="item">{{item}}</a>
                    </template>
                    <template v-else>
                        {{item}}
                    </template>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
    export default {
        name: 'ElencoDati',
        props: ['labels', 'dati']
    }
</script>
