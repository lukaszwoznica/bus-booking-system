<script>
import {Bar} from 'vue-chartjs'

export default {
    extends: Bar,

    props: {
        chartdata: {
            type: Object,
            default: null
        }
    },

    data: () => ({
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    }),

    mounted() {
        this.renderChart(this.chartdata, this.options)
    }
}
</script>
