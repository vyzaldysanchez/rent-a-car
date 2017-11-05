<template>
    <div class="employees">
        <div v-if="!loaded">
            <h3 class="text-center">Loading...</h3>
        </div>
        <div v-if="loaded">
            <employees-form></employees-form>
    
            <hr>

            
        </div>
    </div>
</template>

<script>
    import EmployeesForm from './Forms/EmployeesForm.vue';
    import TableList from './../Views/TableList.vue';
    
    export default {
        components: {
            EmployeesForm,
            TableList
        },
        data() {
            return {
                loaded: false,
                employees: []
            };
        },
        created() {
            this.$axios.get('http://localhost:8000/api/employees')
                .then(resp => {
                    this.employees = resp.data || [];
                    this.loaded = true;
                });
        }
    };
</script>
