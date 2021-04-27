<template>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <form class="d-flex">
            <input class="form-control me-2" :value="modelValue" @input="emitVal" type="search" placeholder="Search" aria-label="Search">
            <button :disabled="btnDisabled" class="btn btn-outline-success ml-1"  @click.prevent="emitSearch" type="submit">Search</button>
            </form>
        </div>
</nav>
</template>

<script>
    export default {
        name:'Search',
        data() {
            return {btnDisabled: true}
        },
        props: {
                modelValue: String
            },
        emits: ['update:modelValue','search'],

        methods: {

                emitVal(e) {
                    this.$emit('update:modelValue',e.target.value)
                },
                emitSearch(){
                    if(this.modelValue.length <= 0)
                        this.btnDisabled = true;
                    this.$emit('search');
                }

        },
        watch: {
            modelValue: function(newvalue,oldvalue){
                if(oldvalue.length > 0)
                    return;
                if(newvalue.length > 0)
                    this.btnDisabled = false;
                else    
                    this.btnDisabled = true;
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
