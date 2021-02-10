<script>
import {Doughnut} from 'vue-chartjs'

export default {
    extends: Doughnut,

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
                display: true,
                position: 'bottom',
                align: 'center'
            }
        }
    }),

    mounted() {
        this.renderChart(this.chartdata, this.options)
    }
}
</script>
