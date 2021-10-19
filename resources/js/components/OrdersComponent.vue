<template>
  <div class="bg">
    <div class="container">
      <div class="row">
        <div class="col-6 col-md-2 p-2">
          <a href="/dashboard" class="btn btn-primary button-login">
            Vai alla Dashboard
          </a>
        </div>
      </div>
      <div
        v-for="(order, index) in orders"
        :key="order.id"
        class="row orders-row"
      >
        <SingleOrder
          :rId="id"
          :oId="order.id"
          :customer_name="order.customer_name"
          :customer_surname="order.customer_surname"
          :customer_address="order.customer_address"
          :customer_email="order.customer_email"
          :customer_phone="order.customer_phone"
          :discount="order.discount"
          :total_price="order.total_price"
          :dishes="order.dishes"
          :notes="order.notes"
          :status="order.status"
          :index="index"
        />
      </div>
    </div>
  </div>
</template>

<script>
import SingleOrder from "./SingleOrder.vue";
export default {
  props: {
    id: Number,
  },
  components: { SingleOrder },
  data() {
    return {
      orders: [],
    };
  },
  created() {
    this.getOrders();
  },
  methods: {
    getOrders() {
      axios.get("/api/orderrestaurant/" + this.id).then((response) => {
        this.orders = response.data.data;
        console.log(response.data);
      });
    },
  },
};
</script>


<style lang="scss" scoped>
@import "../../sass/app.scss";
.bg {
  background-color: $background;
  .orders-row {
    padding-top: 30px;
    padding-bottom: 30px;
  }
}
</style>