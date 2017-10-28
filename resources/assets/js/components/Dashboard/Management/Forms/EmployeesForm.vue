<template>
    <div class="employees-form">
        <form>
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Name" placeholder="John Doe"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input label="Identification" placeholder="403-9879652-0"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-input label="Credit Card" placeholder="4585554818138161865"></fg-input>
                </div>
                <div class="col-md-5">
                    <fg-input label="Credit Limit" placeholder="896.15"></fg-input>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <fg-select label="Person Type"></fg-select>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <button class="btn btn-info btn-fill btn-wd" :class="{'disabled': isSavingVehicle}" @click.prevent="validBeforeSave">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {};
        }
    };
</script>
