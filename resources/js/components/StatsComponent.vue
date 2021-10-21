<template>
    <div class="container">
        <div class="row">
            <statsorders v-if="flagOrder" :orderLabel="orderLabel" :orderData="orderData" class="col-6" />
            <statsbest class="col-6" />

        </div>

    </div>
</template>

<script>
import statsbest from './StatsBest.vue'
import statsorders from './StatsOrder.vue'
import Chart from 'chart.js/auto'
export default {
  components: {
      statsorders,
      statsbest
  },
  props: {
    id: Number,
  },
  mounted() {
      this.getOrder()
  },
  data() {
    return {
        sendOrder: [],
        orderLabel: [],
        orderData: [],
        flagOrder: false
    };
  },
  methods: {
    getOrder() {
        axios.get("/api/ordermonth/" + this.id).then((response) => {
            this.sendOrder = response.data;
            console.log(response.data);
            this.menageData()
            this.flagOrder = true
        });
    },
    menageData() {
        this.sendOrder.forEach((el) => {
            this.orderLabel.push(el['months'])
            this.orderData.push(el['sums'])
        })
    },
  }
};
</script>

<style lang="scss" scoped>

</style>
