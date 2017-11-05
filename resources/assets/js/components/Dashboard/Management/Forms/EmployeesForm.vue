<template>
    <div class="employees-form">
        <form>
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Name" placeholder="Your employee name" v-model="employee.name"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input type="text" label="Identification" :max="13" placeholder="403-9879652-0"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-select label="Schedule" placeholder="Select the work schedule" v-model="employee.schedule"></fg-select>
                </div>
                <div class="col-md-5">
                    <fg-input type="number" label="Commision" v-model="employee.commission"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-input type="date" label="Admission Date" v-model="employee.admissionDate"></fg-input>
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
                employee: {
                    name: '',
                    identification: '',
                    schedule: '',
                    commission: 0.00,
                    admissionDate: this.getDefaultDateValue()
                }
            };
        },
        computed: {
            identification: {
                get() {
                    return this.employee ? this.employee.identification : '';
                },
                set(value) {
                    this.employee.identification = this.$formatter.formatIdentification(value);
                }
            },
        },
        methods: {
            getDefaultDateValue() {
                const date = new Date(),
                    day = date.getDate();
                return `${date.getFullYear()}-${date.getMonth() + 1}-${day < 10 ? ('0' + day) : day}`;
            },
            validBeforeSave() {}
        }
    };
</script>
