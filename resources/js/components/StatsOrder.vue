<template>
    <canvas id="orderChart"></canvas>
</template>

<script>

import Chart from 'chart.js/auto'
export default {
  props: {
      orderLabel: Array,
      orderData: Array
  },
  mounted() {
      this.renderChart()

  },
  computed: {
      

  },
  data() {
    return {

    };
  },
  methods: {
    renderChart() {
        new Chart(document.getElementById('orderChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: this.orderLabel,
                datasets: [{
                    label: 'Vendite per mese',
                    data: this.orderData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
                })
        }
        
    },
};
</script>

<style lang="scss" scoped>

</style>
