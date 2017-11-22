<template>
    <div class="employees">
        <div v-if="!loaded">
            <h3 class="text-center">Loading...</h3>
        </div>
        <div v-if="loaded">
            <employees-form :employee-to-update="employeeToUpdate" @employee-created="addEmployee"
                            @employee-updated="updateEmployee"></employees-form>

            <hr>

            <table-list :columns="columns" :table-data="tableData" :use-actions="true"></table-list>
        </div>
    </div>
</template>

<script>
    import EmployeesForm from './Forms/EmployeesForm.vue';
    import TableList from './../Views/TableList.vue';
    import factory from './../../../factories/factory';
    import {AUTH_USER_KEY} from '../../../services/user.service'

    const columns = [
        'Ord',
        'Name',
        'Identification',
        'Schedule',
        'Commission',
        'Admission',
        'Actions'
    ];

    export default {
        components: {
            EmployeesForm,
            TableList
        },
        data() {
            return {
                loaded: false,
                employeeToUpdate: null,
                employees: [],
                tableData: [],
                columns: [...columns]
            };
        },
        created() {
            this.$storage.getItem(AUTH_USER_KEY).then(user => {
                this.$axios.get(`http://localhost:8000/api/employees?except=${user.id}`).then(resp => {
                    this.employees = resp.data || [];
                    this.loadTableDataFrom(this.employees);
                    this.loaded = true;
                });
            });

            
        },
        watch: {
            employees(val) {
                this.loadTableDataFrom(val);
            }
        },
        methods: {
            loadTableDataFrom(data) {
                this.tableData = data.map((employee, index) => {
                    const {id, name, credentials} = employee;
                    const object = {
                        id,
                        name,
                        credentials,
                        identification: employee['identification_card'],
                        schedule: employee['work_schedule'],
                        commission: employee['commission_percent'],
                        admission: employee['admission_date']
                    };

                    return factory.createForTableList({
                        object,
                        index,
                        onEdit: this.setAsEmployeeToUpdate.bind(this),
                        onRemove: this.askBeforeDeletion.bind(this)
                    });
                });
            },
            setAsEmployeeToUpdate(employee) {
                this.employeeToUpdate = employee;
            },
            askBeforeDeletion(employee) {
                this.$swal({
                    title: 'Are you sure?',
                    html: `The employee <b>${employee.name}</b> and all it's data associated will be deleted.`,
                    type: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true
                }).then(this.deleteEmployee.bind(this, employee));
            },
            deleteEmployee(employeeToDelete) {
                this.$axios.delete(`http://localhost:8000/api/employees/${employeeToDelete.id}`)
                    .then(() => {
                        const index = this.employees.findIndex(
                            employee => employeeToDelete.id === employee.id
                        );
                        this.employees = this.employees.slice(0, index)
                            .concat(this.employees.slice(index + 1));
                    });
            },
            addEmployee(employee) {
                this.employees.push(employee);
            },
            updateEmployee(data) {
                this.employees = this.employees.map(employee => {
                    if (employee.id === data.id) {
                        employee = {...employee, ...data};
                    }

                    return employee;
                });
                this.employeeToUpdate = null;
            }
        }
    };
</script>
