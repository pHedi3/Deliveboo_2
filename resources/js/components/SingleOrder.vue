<template>
  <div
    v-show="this.statusChange != 'hidden' && this.status != 'Complete'"
    class="col-12 singleOrder"
  >
    <div class="row">
      <div class="btn btn-primary button-login">
        Ordine <span class="badge badge-light">{{ index + 1 }}</span>
      </div>
    </div>
    <div class="row order-row rounded">
      <div class="col-sm-12 col-lg-4">
        <div class="card h-100">
          <div class="card-header">Piatti presenti nell' ordine</div>
          <div class="card-body">
            <h5 class="card-title">INFO</h5>
            <div class="card-text">
              <ol>
                <li v-for="dish in dishes" :key="dish.id">{{ dish.name }} x {{dish.pivot.quantity}}</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-lg-4">
        <div class="card h-100">
          <div class="card-header">Informazioni del consumatore</div>
          <div class="card-body">
            <h5 class="card-title">INFO</h5>
            <div class="card-text">
              <ul>
                <li><span>Nome Cliente: </span>{{ customer_name }}</li>
                <li><span>Cognome Cliente: </span>{{ customer_surname }}</li>
                <li><span>Indirizzo Cliente: </span>{{ customer_address }}</li>
                <li><span>Email Cliente: </span>{{ customer_email }}</li>
                <li><span>Telefono Cliente: </span>{{ customer_phone }}</li>
                <li><span>Note: </span>{{ notes }}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-lg-4">
        <div class="card h-100">
          <div class="card-header">Informazione Ordine</div>
          <div class="card-body">
            <h5 class="card-title">INFO</h5>
            <div class="card-text">
              <ul>
                <li><span>Prezzo totale: </span>{{ total_price }}</li>
                <li><span>Codice Sconto: </span>{{ discount }}</li>
                <li><span>Indirizzo Cliente: </span>{{ customer_address }}</li>
                <li><span>Stato dell' ordine: </span>{{ statusChange }}</li>
              </ul>
              <div>
                <form>
                  <div class="form-group">
                    <label for="exampleFormControlSelect1"
                      >Modifica stato dell' ordine</label
                    >
                    <select
                      v-model="statusChange"
                      class="form-control-status"
                      id="exampleFormControlSelect1"
                    >
                      <option>Paid</option>
                      <option>Complete</option>
                    </select>
                  </div>
                </form>
                <button
                  @click="changeStatus()"
                  class="btn btn-primary button-login"
                >
                  Modifica
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
export default {
  props: {
    rId: Number,
    oId: Number,
    customer_name: String,
    customer_surname: String,
    customer_address: String,
    customer_email: String,
    customer_phone: String,
    discount: String,
    total_price: Number,
    dishes: Array,
    status: String,
    index: Number,
    notes: String,
  },
  data() {
    return {
      statusChange: this.status,
    };
  },
  methods: {
    changeStatus() {
      axios
        .put("/api/orders/" + this.oId, {
          name: this.customer_name,
          surname: this.customer_surname,
          address: this.customer_address,
          email: this.customer_email,
          phone: this.customer_phone,
          price: this.total_price,
          discount: this.discount,
          notes: this.notes,
          status: this.statusChange,
        })
        .then((response) => {
          console.log(response.data.data);
          if (this.statusChange == "Complete") {
            this.statusChange = "hidden";
          }
        });
    },
  },
};
</script>



<style lang="scss" scoped>
@import "../../sass/app.scss";

.form-control-status {
  min-width: 190px;
}

.order-row {
  background-color: $background2;
  padding-top: 10px;
  padding-bottom: 10px;
}
.button-login {
  margin-bottom: 5px;
}
</style>