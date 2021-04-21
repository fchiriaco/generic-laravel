<template>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <form class="d-flex">
            <input class="form-control me-2" :value="modelValue" @input="emitVal" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success ml-1"  @click.prevent="emitSearch" type="submit">Search</button>
            </form>
        </div>
</nav>
</template>

<script>
    export default {
        name:'Search',
        props: {
                modelValue: String
            },
        emits: ['update:modelValue','search'],

        methods: {

                emitVal(e) {
                    this.$emit('update:modelValue',e.target.value)
                },
                emitSearch(){
                    this.$emit('search');
                }

        }
    }
</script>

<style lang="scss" scoped>

</style>
