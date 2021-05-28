<<template>
    <div>
        <div id="chart">
            <apexchart height="500" :options="chartOptions" :series="series" ref="packets"></apexchart>
        </div>
    </div>
</template>

<script>
    import VueApexCharts from 'vue-apexcharts';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                series: [{
                    data: []
                }],
                packets: [],
                chartOptions: {
                    chart: {
                        type: "line",
                        stacked: !0,
                        toolbar: {
                            show: !1
                        },
                        zoom: {
                            enabled: !0
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: !1,
                            columnWidth: "25%",
                            endingShape: "rounded"
                        }
                    },
                    xaxis: {
                        type: 'datetime'
                    },
                    legend: {
                        position: 'bottom'
                    },
                    fill: {
                        opacity: 1
                    }
                },
            }
        },

        created(){
            this.listenForNewEvent();
        },

        methods : {

            listenForNewEvent(){
                Echo.join('public-channel')
                .listen('PacketReceiver', (datas) => {
                    this.$parent.new(datas);
                    let x = datas.time;
                    let y = datas.gyro;
                    (this.series[0].data.length > 20) ? this.series[0].data.splice(0, 1) : '';
                    this.series[0].data.push({x,y});
                    this.updateSeriesLine();
                });
            },

            updateSeriesLine(gyro) {
                this.$refs.packets.updateSeries([{
                    data: this.series[0].data,
                }], false, true);
            },
        },

        components: { apexchart: VueApexCharts }
    }
</script>
