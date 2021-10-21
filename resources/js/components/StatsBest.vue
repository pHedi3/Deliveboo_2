<template>
  <canvas id="bestChart"></canvas>
</template>

<script>
import Chart from "chart.js/auto";
export default {
  props: {
    bestName: Array,
    bestData: Array,
  },
  mounted() {
    this.renderChart();
  },
  data() {
    return {};
  },
  methods: {
    renderChart() {
      new Chart(document.getElementById("bestChart").getContext("2d"), {
        type: "bar",
        data: {
          labels: this.bestName,
          datasets: [
            {
              label: "Numero piatti",
              data: this.bestData,
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
              text: "Report vendite piatti mensili",
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
