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
          <div class="card-header">
            <i class="fas fa-utensils"></i>Piatti presenti nell' ordine
          </div>
          <div class="card-body">
            <div class="card-text">
              <ol>
                <li class="dish-list" v-for="dish in dishes" :key="dish.id">
                  {{ dish.name }} x {{ dish.pivot.quantity }}
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-lg-4">
        <div class="card h-100">
          <div class="card-header">
            <i class="fas fa-info-circle"></i>Informazioni del consumatore
          </div>
          <div class="card-body">
            <div class="card-text">
              <ul>
                <li>
                  <span class="inner-text"><strong>Nome:</strong></span
                  >{{ customer_name }}
                </li>
                <li>
                  <span class="inner-text"><strong>Cognome:</strong></span
                  >{{ customer_surname }}
                </li>
                <li>
                  <span class="inner-text"><strong>Indirizzo:</strong></span
                  >{{ customer_address }}
                </li>
                <li>
                  <span class="inner-text"><strong>Email:</strong></span
                  >{{ customer_email }}
                </li>
                <li>
                  <span class="inner-text"><strong>Telefono:</strong></span
                  >{{ customer_phone }}
                </li>
                <li>
                  <span class="inner-text"><strong>Note:</strong></span
                  >{{ notes }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-lg-4">
        <div class="card h-100">
          <div class="card-header">
            <i class="fas fa-file-alt"></i>Informazione Ordine
          </div>
          <div class="card-body">
            <div class="card-text">
              <ul>
                <li>
                  <span class="inner-text"><strong>Prezzo totale:</strong></span
                  >{{ total_price }}
                </li>
                <li>
                  <span class="inner-text"><strong>Codice Sconto:</strong></span
                  >{{ discount }}
                </li>
                <li>
                  <span class="inner-text"><strong>Indirizzo:</strong></span
                  >{{ customer_address }}
                </li>
                <li>
                  <span class="inner-text"
                    ><strong>Stato dell' ordine:</strong></span
                  >{{ statusChange }}
                </li>
              </ul>
              <div>
                <form>
                  <div class="form-group">
                    <label for="exampleFormControlSelect1"
                      ><strong>Modifica stato dell' ordine</strong></label
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

.inner-text {
  padding: 5px;
}
i {
  padding: 5px;
}

.dish-list::marker {
  font-weight: bold;
}
</style>