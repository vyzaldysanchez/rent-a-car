<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-plain">
                <paper-table type="hover" :title="title" :sub-title="subTitle" :data="tableData"
                             :columns="columns">

                </paper-table>
            </div>
        </div>
    </div>
</template>
<script>
    import PaperTable from '../../UIComponents/PaperTable.vue'

    export default {
        components: {
            PaperTable
        },
        props: {
            title: {type: String, default: ''},
            subTitle: {type: String, default: ''},
            columns: [],
            tableData: []
        },
        data() {
            return {

            }
        }
    }

</script>
<style>

</style>
