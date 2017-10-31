<template>
    <div class="clients-form">
        <form>
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Name" placeholder="John Doe" v-model="client.name"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input type="text" label="Identification" :max="13" placeholder="403-9879652-0" v-model="identification"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Credit Card" placeholder="4585554818138161865" :max="19" v-model="client.creditCard"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input label="Credit Limit" placeholder="896.15" type="number" v-model="client.creditLimit"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-select label="Person Type" placeholder="Select a person type" v-model="client.personType" :options="personTypes" @change="updateClientId"></fg-select>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <button class="btn btn-info btn-fill btn-wd" :class="{'disabled': isSavingClient}" @click.prevent="validBeforeSave">Save</button>
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
                isSavingClient: false,
                isFormValid: true,
                formErrors: [],
                onEditionMode: false,
                get identification() {
                    return this.client.identification;
                },
                set identification(value) {
                    this.client.identification = value
                        .replace(/\D+/g, '')
                        .replace(/^(\d{3})(\d{7})(\d{1})$/, '$1-$2-$3');
                },
                client: {
                    name: '',
                    identification: '',
                    creditCard: '',
                    creditLimit: 0,
                    personType: 1
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
            updateClientId(id) {
                this.client.personType = id;
            },
            validBeforeSave() {
                if (this.isSavingClient) {
                    return;
                }
    
                this.isFormValid = true;
                this.formErrors = [];
    
                this.validateName();
                this.validateIdentification();
                this.validateName();
                this.validateCreditCard();
                this.validateCreditLimit();
                this.validatePersonType();
    
                if (this.formHasErrors) {
                    this.notifyErrors();
                } else {
                    const actionPerformed = this.onEditionMode ? 'updated' : 'created';
    
                    this.$swal({
                        title: 'Are you sure?',
                        html: `The client <b>${this.client
                        .name}</b> will be ${actionPerformed}.`,
                        type: 'warning',
                        showConfirmButton: true,
                        showCancelButton: true
                    }).then(this.save.bind(this));
                }
            },
            isIdentificationValid(value) {
                return /\d{3}-\d{7}-\d{1}/.test(value);
            },
            validateName() {
                this.isFormValid = this.isFormValid && !!this.client.name;
    
                if (!this.isFormValid) {
                    this.formErrors.push('The name field is empty');
                }
            },
            validateIdentification() {
                this.isFormValid =
                    this.isFormValid &&
                    this.isIdentificationValid(this.client.identification);
    
                if (!this.isFormValid) {
                    this.formErrors.push('The identification format is not correct.');
                }
            },
            validateCreditCard() {
                const lengthIsValid = this.client.creditCard.length === 19,
                    formatIsValid = this.client.creditCard.match(/\d/g);
    
                this.formIsValid = this.formIsValid && lengthIsValid && formatIsValid;
    
                if (!lengthIsValid) {
                    this.formErrors.push(
                        'The credit card number length is no 19 characters.'
                    );
                }
    
                if (!formatIsValid) {
                    this.formErrors.push(
                        'Only numeric chars are allowed for a credit card.'
                    );
                }
            },
            validateCreditLimit() {
                this.isFormValid = this.isFormValid && this.client.creditLimit > 0;
    
                if (!this.isFormValid) {
                    this.formErrors.push('The credit limit is not valid.');
                }
            },
            validatePersonType() {
                this.isFormValid = this.isFormValid && this.client.personType > 0;
    
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
            },
            save() {
                const body = {
                    name: this.client.name,
                    identification_number: this.client.identification,
                    credit_card_number: this.client.creditCard,
                    credit_limit: this.client.creditLimit,
                    person_type_id: this.client.personType
                };
    
                this.isSavingClient = true;
    
                this.sendRequest(body)
                    .then(resp => {
                        this.isSavingClient = false;
                    })
                    .catch(error => {
                        this.formIsValid = false;
                        this.formErrors.push(error.response.data.message);
                        this.notifyErrors();
                        this.isSavingClient = false;
                    });
            },
            sendRequest(body) {
                return this.onEditionMode ?
                    this.getClientUpdatePromise(body) :
                    this.getClientCreationPromise(body);
            },
            getClientCreationPromise(body) {
                return this.$axios.post('http://localhost:8000/api/clients', body);
            },
            getClientUpdatePromise(body) {
                return this.$axios.put(
                    `http://localhost:8000/api/clients/${this.$props.client.id}`,
                    body
                );
            }
        }
    };
</script>
