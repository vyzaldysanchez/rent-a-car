<template>
    <div class="employees">
        <div v-if="!isLoaded">
            <h3 class="text-center">Loading...</h3>
        </div>
        <div v-if="isLoaded">
            <clients-form></clients-form>
    
            <hr>
    
            <table-list :columns="tableColumns" :table-data="employees" :use-actions="true"></table-list>
        </div>
    </div>
</template>

<script>
    import ClientsForm from './Forms/ClientsForm.vue';
    import TableList from './../Views/TableList.vue';
    import factory from './../../../factories/factory';
    
    const tableColumns = [
        'Ord',
        'Name',
        'Identification',
        'CreditCard',
        'CreditLimit',
        'PersonType',
        'State',
        'Actions'
    ];
    let personTypesSource = [];
    
    export default {
        components: {
            TableList,
            ClientsForm
        },
        data() {
            return {
                tableColumns: [...tableColumns],
                isLoaded: false,
                employees: []
            };
        },
        computed: {
             personTypes:{
                 get() {
                     return personTypesSource;
                 }
            }
        },
        created() {
            Promise.all([
                this.$axios.get('http://localhost:8000/api/clients'),
                this.$axios.get('http://localhost:8000/api/person_types')
            ]).then(res => {
                const [respEmployees, respPersonTypes] = res;
                const employees = respEmployees.status === 204 ? [] : respEmployees.data.slice(0);
                personTypesSource = respPersonTypes.status === 204 ? [] : respPersonTypes.data.slice(0);
                this.employees = employees.map(this.createEmployeeAsTableItem.bind(this));
                this.isLoaded = true;
            });
        },
        methods: {
            createEmployeeAsTableItem(employee, index) {
                const object = {
                    name: employee.name,
                    identification: employee.identification_number,
                    creditcard: employee.credit_card_number,
                    creditlimit: employee.credit_limit,
                    persontype: personTypesSource.find(personType => personType.id == employee.person_type_id).name,
                    state: employee.state
                };
    
                return factory.createForTableList({
                    object,
                    index,
                    onEdit: null,
                    onRemove: null
                });
            }
        }
    };
</script>