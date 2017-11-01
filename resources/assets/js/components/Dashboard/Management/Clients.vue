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
        created() {
            Promise.all([
                this.$axios.get('http://localhost:8000/api/clients'),
                this.$axios.get('http://localhost:8000/api/person_types')
            ]).then(res => {
                const [respEmployees, respPersonTypes] = res;
                const employees = respEmployees.status === 204 ? [] : respEmployees.data.slice(0);
                const personTypes = respPersonTypes.status === 204 ? [] : respPersonTypes.data.slice(0);
    
                this.employees = employees.map((employee, index) => {
                    const object = {
                        name: employee.name,
                        identification: employee.identification_number,
                        creditcard: employee.credit_card_number,
                        creditlimit: employee.credit_limit,
                        persontype: personTypes.find(personType => personType.id == employee.person_type_id).name,
                        state: employee.state
                    };
    
                    return factory.createForTableList({
                        object,
                        index,
                        onEdit: null,
                        onRemove: null
                    });
                });
    
                this.isLoaded = true;
            });
        }
    };
</script>