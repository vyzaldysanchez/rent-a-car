<template>
  <div id="rents-form">
    <h2 class="title text-center">Rent a car! <i class="ti-car"></i></h2>

    <hr />

    <form>
      <div class="col-md-6 form-group">
        <fg-select :options="vehicles" id="vehicle" name="vehicle" label="Vehicle to rent" placeholder="Select the vehicle to rent"></fg-select>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-select :options="clients" id="client" name="client" label="Client who rents" placeholder="Select the client to rent the car"></fg-select>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="date" id="rentDate" name="rentDate" label="Rent date" v-model="rent.date"></fg-input>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="date" id="returnDate" name="returnDate" label="Return date" v-model="rent.returnDate"></fg-input>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="number" id="fair" name="fair" label="Daily fair" v-model="rent.dailyFair" :min="0.00"></fg-input>
      </div>
      
      <div class="col-md-6 form-group">
        <fg-input type="number" id="days" name="days" label="Rent days" v-model="rent.rentDays" :min="1"></fg-input>
      </div>
      
      <div class="col-md-12 form-group">
        <fg-textarea label="Comment" id="comment" name="comment"></fg-textarea>
      </div>

      <div class="form-group">
        <button type="button" class="btn btn-primary btn-fill center-block">
          Make rent!
        </button>
      </div>
    </form>
  </div>
</template>

<style lang="scss" scoped>
.title {
  margin: 15px 0;
}
</style>


<script>
import fgSelectHelper from './../../../UIComponents/Inputs/Helpers/fg-select.helper';

export default {
  data() {
    return {
      rent: {
        dailyFair: 0.0,
        rentDays: 1,
        date: null,
        returnDate: null
      },
      vehicles: [],
      clients: []
    };
  },
  created() {
    this.getFormDataRequest().then(res => {
      const [vehicles, clients] = res;

      this.vehicles = fgSelectHelper.mapToSelectListItem(vehicles.data, [
        'id',
        'description'
      ]);
      this.clients = fgSelectHelper.mapToSelectListItem(clients.data, [
        'id',
        'name'
      ]);

      this.$emit('loaded');
    });
  },
  methods: {
    getFormDataRequest() {
      return Promise.all([
        this.$axios.get('http://localhost:8000/api/vehicles'),
        this.$axios.get('http://localhost:8000/api/clients')
      ]);
    }
  }
};
</script>