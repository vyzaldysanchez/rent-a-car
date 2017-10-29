<template>
    <div class="employees-form">
        <form>
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Name" placeholder="John Doe" v-model="employee.name"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input label="Identification" placeholder="403-9879652-0" v-model="employee.identification"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Credit Card" placeholder="4585554818138161865" v-model="employee.creditCard"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input label="Credit Limit" placeholder="896.15" type="number" v-model="employee.creditLimit"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-select label="Person Type" placeholder="Select a person type" v-model="employee.personType" :options="personTypes" @change="updateEmployeeId"></fg-select>
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
    export default {
        data() {
            return {
                isSavingEmployee: false,
                isFormValid: true,
                formErrors: [],
                employee: {
                    name: '',
                    identification: '',
                    creditCard: '',
                    creditLimit: 0,
                    personType: 0
                },
                personTypes: []
            };
        },
        computed: {
            formHasErrors() {
                return this.formErrors.length > 0;
            }
        },
        mounted() {
            this.$axios.get('http://localhost:8000/api/person_types').then(
                resp =>
                (this.personTypes = resp.data.map(personType => ({
                    value: personType.id,
                    label: personType.name
                })))
            );
        },
        methods: {
            updateEmployeeId(id) {
                this.employee.personType = id;
            },
            validBeforeSave() {
                if (this.isSavingEmployee) {
                    return;
                }
    
                this.formErrors = [];
    
                this.validateName();
                this.validateIdentification();
                this.validateName();
                this.validateCreditCard();
                this.validateCreditLimit();
                this.validatePersonType();    

                if (this.formHasErrors) {
                    this.notifyErrors();
                } else {}
            },
            isIdentificationValid(value) {
                return /\d{3}-\d{7}-\d{1}/.test(value);
            },
            validateName() {
                this.isFormValid = this.isFormValid && !!this.employee.name;
    
                if (!this.isFormValid) {
                    this.formErrors.push('The name field is empty');
                }
            },
            validateIdentification() {
                this.isFormValid =
                    this.isFormValid &&
                    this.isIdentificationValid(this.employee.identification);
    
                if (!this.isFormValid) {
                    this.formErrors.push('The identification format is not correct.');
                }
            },
            validateCreditCard() {
                this.isFormValid =
                    this.isFormValid && this.employee.creditCard.length !== 19;
    
                if (!this.isFormValid) {
                    this.formErrors.push('The credit card number is no 19 characters.');
                }
            },
            validateCreditLimit() {
                this.isFormValid = this.isFormValid && this.employee.creditLimit > 0;
    
                if (!this.isFormValid) {
                    this.formErrors.push('The credit limit is not valid.');
                }
            },
            validatePersonType(){
                this.isFormValid = this.isFormValid && this.employee.personType > 0;

                 if (!this.isFormValid) {
                    this.formErrors.push('The person type selected is not valid.');
                }
            },
            getFormErrorListAsHTML() {
                const errorList = this.formErrors.reduce(
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
            }
        }
    };
</script>
