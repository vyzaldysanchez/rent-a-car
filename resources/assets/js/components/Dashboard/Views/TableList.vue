<template>
    <div class="row">
        <div class="col-md-12">
            <fg-input name="search-box" placeholder="Search..."
                      v-model="valueToSearch" @input="filterItems()"></fg-input>
            <div class="card card-plain">
                <paper-table type="hover" :title="title" :sub-title="subTitle" :data="items"
                             :columns="columns">
                </paper-table>
            </div>
            <pager :items-per-page="15" :items="this.$props.tableData" @pager-update="updateItemsDisplayed"></pager>
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
        computed: {
            items() {
                return this.filteredItems.slice(0, 15);
            }
        },
        data() {
            return {
                valueToSearch: '',
                filteredItems: this.$props.tableData.slice(0)
            };
        },
        methods: {
            filterItems() {
                this.filteredItems = this.$props.tableData.filter(item => {
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
