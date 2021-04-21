<template>

        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Token</th>
                    <th scope="col">Abilities</th>
                    <th scope="col">Elimina</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="token in tokens" :key="token.name">
                <td>{{token.name}}</td><td>{{token.token}}</td>
                <td>{{token.abilities}}</td>
                <td><a @click.prevent="delToken(token.id)" class="btn btn-danger" id="elimina" :href="`/tokendel/${token.id}`">Elimina</a></td>
                </tr>
            </tbody>
        </table>


</template>

<script>
    export default {
        name: 'Token',
        props: ['tokens'],
        emits: ['elimina-token'],
        methods: {
                    delToken(id) {

                                    window.axios.delete(`/tokendel/${id}`)
                                    .then((response) => {
                                                this.$emit('elimina-token',id)
                                        })
                                        .catch((e)=> console.log(e));


                                }
                },

    }

</script>

<style lang="scss" scoped>

</style>
