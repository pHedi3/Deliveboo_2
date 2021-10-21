<template>
  <div class="back">
    <div class="loading" v-show="!flagBest && !flagOrder">Attendi...</div>
    <div v-show="flagBest && flagOrder" class="container">
      <div class="row">
        <div class="col-6 col-md-2 p-2">
          <a href="/dashboard" class="btn btn-primary button-login">
            Vai alla Dashboard
          </a>
        </div>
        <statsorders
          v-if="flagOrder"
          :orderLabel="orderLabel"
          :orderData="orderData"
          class="col-12"
        />
        <statsbest
          v-if="flagBest"
          :bestName="bestName"
          :bestData="bestData"
          class="col-12"
        />
      </div>
    </div>
  </div>
</template>

<script>
import statsbest from "./StatsBest.vue";
import statsorders from "./StatsOrder.vue";
import Chart from "chart.js/auto";
export default {
  components: {
    statsorders,
    statsbest,
  },
  props: {
    id: Number,
  },
  mounted() {
    this.getOrder();
    this.getBest();
    this.getMonth();
  },
  data() {
    return {
      sendOrder: [],
      orderLabel: [],
      orderData: [],
      best: [],
      bestName: [],
      bestData: [],
      flagOrder: false,
      flagBest: false,
      month: "",
    };
  },
  methods: {
    getOrder() {
      axios.get("/api/ordermonth/" + this.id).then((response) => {
        this.sendOrder = response.data;
        console.log(response.data);
        this.menageData();
        this.flagOrder = true;
      });
    },
    getBest() {
      axios.get("/api/bestdish/" + this.id).then((response) => {
        this.best = response.data;
        console.log(response.data);
        this.menageBest();
      });
    },
    getMonth() {
      axios.get("/api/month").then((response) => {
        this.month = response.data;
        console.log(response.data);
        this.menageBest();
      });
    },
    menageData() {
      this.sendOrder.forEach((el) => {
        this.orderLabel.push(el["months"]);
        this.orderData.push(el["sums"]);
      });
    },
    menageBest() {
      if (this.best != [] && this.month != "") {
        this.best.forEach((el) => {
          if (el["months"].includes(this.month)) {
            this.bestName.push(el["name"]);
            this.bestData.push(el["countDish"]);
          }
        });
        this.flagBest = true;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../sass/app.scss";
.back {
  .loading {
    display: flex;
    justify-content: center;
    align-items: center;
    color: black;
    font-size: 16px;
    height: 100px;
  }
}
</style>
