<template>
    <div class="container">
        <div class="row">
            <statsorders :sendOrder="sendOrder" class="col-6" />
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
        allOrders: [],
        moneyForMonth: [],
        sendOrder: []

    };
  },
  methods: {
    manageData() {
        this.allOrders.forEach((order) => {
            let year = order.data.split('-')[0] 
            let month = order.data.split('-')[1] 
            let money = {
                'money': order.total_price,
                'year': year,
                'month':  month
            }
            this.moneyForMonth.push(money)
        })
        this.moneyForMonth.forEach((order, index) => {
            if (index == 0) {
                this.sendOrder.push(order)
            } else {
                this.sendOrder.forEach((element) => {
                    if (order.month != element.month && order.year != order.year) {
                        this.sendOrder.push(order)
                    } else {
                        element.money += order.money
                        console.log(element)
                    }
                });
            }
        })
        // this.sendOrder.sort(function(a, b) {
        //     return a.month - b.month;
        // })
    },
    getOrder() {
        axios.get("/api/orderrestaurant/" + this.id).then((response) => {
        this.allOrders = response.data.data;
        console.log(response.data);
        this.manageData()
      });
    }
  }
};
</script>

<style lang="scss" scoped>

</style>
