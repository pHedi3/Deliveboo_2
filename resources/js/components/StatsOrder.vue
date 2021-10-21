<template>
  <canvas id="orderChart"></canvas>
</template>

<script>
import Chart from "chart.js/auto";
export default {
  props: {
    orderLabel: Array,
    orderData: Array,
  },
  mounted() {
    this.renderChart();
  },
  computed: {},
  data() {
    return {};
  },
  methods: {
    renderChart() {
      new Chart(document.getElementById("orderChart").getContext("2d"), {
        type: "line",
        data: {
          labels: this.orderLabel,
          datasets: [
            {
              label: "Numero ordini",
              data: this.orderData,
              backgroundColor: [
                "rgba(0, 0,	255, 0.2)",
                "rgba(51, 51, 255,	0.2)",
                "rgba(92, 92, 255, 0.2)",
                "rgba(125, 125, 255, 0.2)",
                "rgba(151, 151, 255, 0.2)",
                "rgba(172, 172, 255, 0.2)",
              ],
              borderColor: [
                "rgba(0, 0,	255, 1)",
                "rgba(51, 51, 255,	1)",
                "rgba(92, 92, 255, 1)",
                "rgba(125, 125,	255, 1)",
                "rgba(151, 151, 255, 1)",
                "rgba(172, 172, 255, 1)",
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
          plugins: {
            title: {
              display: true,
              text: "Report ordini mensili",
              font: {
                size: 30,
              },
            },
            legend: {
              display: true,
              position: "right",
            },
          },
        },
      });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
