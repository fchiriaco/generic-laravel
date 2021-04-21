<template>
    <nav aria-label="Page navigation" class="p-0 m-0" v-if="mostra_navigazione()">
        <ul class="pagination">
            <li v-if="primo_link()" class="page-item"><a class="page-link" :href="links[0].url">Previous</a></li>
            <template v-for="link in links">
                <template v-if="mostra_button(link)">
                    <li v-if="link_attivo(link)" class="page-item" :key="link.url"><button class="btn btn-secondary">{{link.label}}</button></li>
                    <li v-else class="page-item" :key="link.url"><a class="page-link" :href="link.url">{{link.label}}</a></li>
                </template>
            </template>

            <li v-if="last_link()" class="page-item"><a class="page-link" :href="links[links.length -1].url">Next</a></li>
        </ul>
    </nav>

</template>

<script>
    export default {
        name: 'NavPages',
        props:['links'],
        methods: {
            mostra_navigazione() {
                if (this.links[0].url !== null || this.links[this.links.length -1].url !== null)
                    return true;
                else
                    return false;

            },
            primo_link() {
                    if(this.links[0].url !== null)
                        return true;
                    else
                        return false;
            },
            last_link() {
                    if(this.links[this.links.length -1].url !== null)
                        return true;
                    else
                        return false;
            },
            link_attivo(link){
                if(link.active==true)
                    return true;
                else
                    return false;
            },
            mostra_button(link){
                if((link.label !== this.links[0].label) && (link.label !== this.links[this.links.length -1].label))
                    return true;
                else
                    return false;
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
