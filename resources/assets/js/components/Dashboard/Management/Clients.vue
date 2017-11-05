<template>
    <div class="employees">
        <div v-if="!isLoaded">
            <h3 class="text-center">Loading...</h3>
        </div>
        <div v-if="isLoaded">
            <clients-form :client-to-update="clientToEdit" @client-created="addClient" @client-updated="updateClient"></clients-form>
    
            <hr>
    
            <table-list :columns="tableColumns" :table-data="clients" :use-actions="true"></table-list>
        </div>
    </div>
</template>

<script>
    import ClientsForm from './Forms/ClientsForm.vue';
    import TableList from './../Views/TableList.vue';
    import factory from './../../../factories/factory';
    import formUtils from './../../../utils/form.utils';
    
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
                clients: [],
                clientToEdit: null
            };
        },
        computed: {
            personTypes: {
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
                const [respClients, respPersonTypes] = res;
                const clients = respClients.status === 204 ? [] : respClients.data.slice(0);
                personTypesSource = respPersonTypes.status === 204 ? [] : respPersonTypes.data.slice(0);
                this.clients = clients.map(this.createClientAsTableItem.bind(this));
                this.isLoaded = true;
            });
        },
        methods: {
            createClientAsTableItem(client, index) {
                const personType = personTypesSource.find(personType => personType.id == client.person_type_id);
                const object = {
                    id: client.id,
                    name: client.name,
                    identification: client.identification_number,
                    creditcard: client.credit_card_number,
                    creditlimit: client.credit_limit,
                    persontype: personType.name,
                    personTypeId: personType.id,
                    state: client.state
                };
    
                return factory.createForTableList({
                    object,
                    index,
                    onEdit: this.edit,
                    onRemove: this.askToRemove
                });
            },
            addClient(clientRes) {
                const client = Object.assign(clientRes, {
                    person_type_id: clientRes.personType,
                    identification_number: clientRes.identification,
                    credit_card_number: clientRes.creditCard,
                    credit_limit: clientRes.creditLimit,
                    state: clientRes.state || 'ACTIVE'
    
                });
                this.clients.push(this.createClientAsTableItem(client, this.clients.length));
            },
            edit(client) {
                this.clientToEdit = client;
            },
            updateClient(data) {
                this.clients = this.clients.map(client => {
                    if (client.id === data.id) {
                        client = Object.assign(client, data);
                    }
    
                    return client;
                });
                this.clientToEdit = null;
            },
            askToRemove(client) {
                this.$swal({
                    title: 'Are you sure?',
                    html: `The client <b>${client.name}</b> and all it's data associated will be deleted.`,
                    type: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then(this.delete.bind(this, client));
            },
            delete(clientToDelete) {
                this.$axios.delete(`http://localhost:8000/api/clients/${clientToDelete.id}`)
                    .then(() => {
                        const index = this.clients.findIndex(client => clientToDelete.id === client.id);
                        this.clients = this.clients.slice(0, index).concat(this.clients.slice(index + 1));
                    });
            }
        }
    };
</script>