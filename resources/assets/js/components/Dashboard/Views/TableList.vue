<template>
    <div class="row">
        <div class="col-md-12">
            <fg-input name="search-box" placeholder="Search..."
                      v-model="valueToSearch" @input="filterItems()"></fg-input>
            <div class="card card-plain">
                <paper-table type="hover" :title="title" :sub-title="subTitle" :data="filteredItems.slice(0, 15)"
                             :columns="columns">
                </paper-table>
            </div>
            <pager :items-per-page="15" :items="initialData" @pager-update="updateItemsDisplayed"></pager>
        </div>
    </div>
</template>
<script>
    import PaperTable from '../../UIComponents/PaperTable.vue'
    import Pager from '../../UIComponents/Pager.vue'

    export default {
        components: {
            Pager,
            PaperTable
        },
        props: {
            title: {type: String, default: ''},
            subTitle: {type: String, default: ''},
            columns: Array,
            tableData: Array
        },
        data() {
            return {
                valueToSearch: '',
                initialData: this.$props.tableData.slice(0),
                filteredItems: []
            };
        },
        mounted() {
            this.filteredItems = this.initialData.slice(0);
        },
        methods: {
            filterItems() {
                this.filteredItems = this.initialData = this.$props.tableData.filter(item => {
                    return Object.keys(item).some(prop => {
                        return item[prop].toString().toLowerCase().indexOf(this.valueToSearch) !== -1;
                    });
                });
            },
            updateItemsDisplayed(items) {
                this.filteredItems = items;
            }
        }
    }

</script>
<style>

</style>
