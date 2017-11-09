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
  'Admission'
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
  methods: {
    loadTableDataFrom(data) {
      this.tableData = data.map((employee, index) => {
        const object = {
          name: employee.name,
          identification: employee['identification_card'],
          schedule: employee['work_schedule'],
          commission: employee['commission_percent'],
          admission: employee['admission_date']
        };

        return factory.createForTableList({
          object,
          index,
          onEdit: null,
          onRemove: null
        });
      });
    }
  }
};
</script>
