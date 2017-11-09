<template>
    <div class="employees">
        <div v-if="!loaded">
            <h3 class="text-center">Loading...</h3>
        </div>
        <div v-if="loaded">
            <employees-form></employees-form>
    
            <hr>

            <table-list :columns="columns" :table-data="tableData" :use-actions="true"></table-list> 
        </div>
    </div>
</template>

<script>
const columns = [
  'Ord',
  'Name',
  'Identification',
  'Schedule',
  'Commission',
  'Admission',
  'Actions'
];

import EmployeesForm from './Forms/EmployeesForm.vue';
import TableList from './../Views/TableList.vue';
import factory from './../../../factories/factory';

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
    this.$axios.get('http://localhost:8000/api/employees').then(resp => {
      this.employees = resp.data || [];
      this.loadTableDataFrom(this.employees);
      this.loaded = true;
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
        const object = {
          id: employee.id,
          name: employee.name,
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
      }).then(this.delete.bind(this, employee));
    },
    delete(employeeToDelete) {
      this.$axios
        .delete(`http://localhost:8000/api/employees/${employeeToDelete.id}`)
        .then(() => {
          const index = this.employees.findIndex(
            employee => employeeToDelete.id === employee.id
          );
          this.employees = this.employees
            .slice(0, index)
            .concat(this.employees.slice(index + 1));
        });
    }
  }
};
</script>
