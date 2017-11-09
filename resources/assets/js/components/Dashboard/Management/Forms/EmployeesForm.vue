<template>
    <div class="employees-form">
        <form>
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Name" placeholder="Your employee name" v-model="employee.name"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input type="text" label="Identification" :max="13" placeholder="403-9879652-0" v-model="identification"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-select label="Schedule" placeholder="Select the work schedule" :options="schedules" @change="selectSchedule"></fg-select>
                </div>
                <div class="col-md-5">
                    <fg-input type="number" label="Commision (%)" v-model="commission"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-input type="date" label="Admission Date" v-model="employee.admissionDate"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-check label="Activate user" name="credentials" id="credentials" @change="toggleCredentials"></fg-check>
                </div>
                <div class="col-md-12" v-if="activateCredentials">
                    <div class="col-md-6 col-md-offset-3">
                        <fg-input type="email" label="Email" name="emp-email" v-model="employee.credentials.email"></fg-input>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <fg-input type="password" label="Password" name="emp-password" v-model="employee.credentials.password"></fg-input>                        
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <fg-input type="password" label="Confirm password" name="emp-password-2" v-model="passwordConfirmation"></fg-input>                        
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <button class="btn btn-info btn-fill btn-wd" :class="{'disabled': isSavingEmployee}" @click.prevent="validBeforeSave">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
const workSchedules = [
  { value: 'Morning', label: 'Morning' },
  { value: 'Afternoon', label: 'Afternoon' },
  { value: 'Night', label: 'Night' }
];

export default {
  props: {
    edit: [Boolean]
  },
  data() {
    return {
      isSavingEmployee: false,
      activateCredentials: false,
      passwordConfirmation: '',
      formIsValid: false,
      errors: [],
      schedules: [...workSchedules],
      employee: {
        name: '',
        identification: '',
        schedule: '',
        commission: 0.0,
        admissionDate: this.getDefaultDateValue(),
        credentials: {
          email: '',
          password: ''
        }
      }
    };
  },
  computed: {
    identification: {
      get() {
        return this.employee ? this.employee.identification : '';
      },
      set(value) {
        this.employee.identification = this.$formatter.formatIdentification(
          value
        );
      }
    },
    commission: {
      get() {
        return this.employee ? this.employee.commission : 0;
      },
      set(val) {
        const amount = Number.parseFloat(val);
        this.employee.commission = amount < 0 ? 0 : amount;
      }
    }
  },
  methods: {
    getDefaultDateValue() {
      const date = new Date(),
        day = date.getDate();
      return `${date.getFullYear()}-${date.getMonth() + 1}-${day < 10
        ? '0' + day
        : day}`;
    },
    toggleCredentials(val) {
      this.activateCredentials = val;
    },
    selectSchedule(val) {
      this.employee.schedule = val;
    },
    validBeforeSave() {
      this.formIsValid = true;
      this.errors = [];

      this.validateName();
      this.validateIdentification();
      this.validateSchedule();
      this.validateCommission();

      if (this.activateCredentials) {
        this.validateCredentials();
      }

      if (!this.formIsValid) {
        this.notifyErrors();
      } else {
        this.$swal({
          title: 'Are you sure?',
          html: `The employee <b>${this.employee
            .name}</b> will be ${this.getActionToPerform()}.`,
          type: 'warning',
          showConfirmButton: true,
          showCancelButton: true
        }).then(this.save.bind(this));
      }
    },
    validateName() {
      const nameIsValid = !!this.employee.name.trim();
      this.formIsValid = this.formIsValid && nameIsValid;

      if (!nameIsValid) {
        this.errors.push('Name field is empty.');
      }
    },
    validateIdentification() {
      const isValid = this.isIdentificationValid(this.employee.identification);
      this.formIsValid = this.formIsValid && isValid;

      if (!isValid) {
        this.errors.push('Identification format is invalid.');
      }
    },
    isIdentificationValid(value) {
      return /\d{3}-\d{7}-\d{1}/.test(value);
    },
    validateSchedule() {
      const isValid = !!this.employee.schedule;

      this.formIsValid = this.formIsValid && isValid;

      if (!isValid) {
        this.errors.push('An schedule should be selected.');
      }
    },
    validateCommission() {
      const isValid = this.employee.commission >= 0;

      this.formIsValid = this.formIsValid && isValid;

      if (!isValid) {
        this.errors.push('The commision should not be negative.');
      }
    },
    validateCredentials() {
      const { email, password } = this.employee.credentials;
      const emailIsValid = this.isEmailValid(email);
      const passwordIsValid = this.isPasswordValid(password);

      if (!emailIsValid) {
        this.errors.push('Only valid emails are allowed.');
      }

      if (!passwordIsValid) {
        this.errors.push('Passwords do not match.');
      }

      this.formIsValid = this.formIsValid && emailIsValid && passwordIsValid;
    },
    isEmailValid(email) {
      const validEmailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return !!email.trim() && validEmailRegex.test(email);
    },
    isPasswordValid(password) {
      return !!password.trim() && password === this.passwordConfirmation;
    },
    getFormErrorListAsHTML() {
      const errorList = this.errors.reduce(
        (htmlErrors, error) => `${htmlErrors}<li>${error}</li>`,
        ``
      );
      return `<ul>${errorList}</ul>`;
    },
    notifyErrors() {
      this.$notifications.notify({
        message: this.getFormErrorListAsHTML(),
        type: 'danger',
        verticalAlign: 'bottom',
        horizontalAlign: 'right',
        icon: 'fa fa-warning'
      });
    },
    getActionToPerform() {
      return this.edit ? 'updated' : 'created';
    },
    save() {
      const body = {
        name: this.employee.name,
        identification_card: this.identification,
        work_schedule: this.employee.schedule,
        commission_percent: this.commission,
        admission_date: this.employee.admissionDate
      };

      if (this.activateCredentials) {
        body.credentials = this.employee.credentials;
      }

      this.isSavingEmployee = true;

      this.$axios
        .post('http://localhost:8000/api/employees', body)
        .then(resp => {
          const eventToEmit = this.onEditionMode
              ? 'employee-updated'
              : 'employee-created';

          this.isSavingEmployee = false;
          //this.clearForm();
          //this.$emit(eventToEmit, body);
        })
        .catch(error => {
          this.formIsValid = false;
          this.errors.push(error.response.data.message);
          this.notifyErrors();
          this.isSavingEmployee = false;
        });
    }
  }
};
</script>
