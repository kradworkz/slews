<template>
    <div id="chart">
        <div class="float-left">
            <div class="input-group input-group-sm">
                
                <select v-model="type" class="custom-select custom-select-sm ml-2" style=" width: 100px;">
                    <option value="All">All</option>
                    <option value="Daily">Daily</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                </select>
                <input type="date" v-model="todate" class="custom-select custom-select-sm"  v-if="month == 'Daily'" style="margin-right: 10px; margin-left: 10px;width: 100px;">
                <input type="text" v-model="year" class="custom-select custom-select-sm"  v-if="type == 'Yearly'" style="margin-right: 10px; margin-left: 10px;width: 100px;">
                <select class="custom-select custom-select-sm" style="width: 200px;">
                    <!-- <option :value="lab" v-for="lab in laboratories" v-bind:key="lab.id">{{lab.name}}</option> -->
                </select>
                <div class="input-group-append">
                    <label class="input-group-text">Services</label>
                </div>
            </div>
        </div>
        <div class="toolbar">
            <button id="one_month"
                @click="updateData('one_month')" :class="{active: selection==='one_month'}"
                >
                1M
            </button>
            
            <button id="six_months"
                @click="updateData('six_months')" :class="{active: selection==='six_months'}"
                >
                6M
            </button>
            
            <button id="one_year"
                
                @click="updateData('one_year')" :class="{active: selection==='one_year'}"
                >
                1Y
            </button>
            
            <button id="ytd"
                @click="updateData('ytd')" :class="{active: selection==='ytd'}"
                >
                YTD
            </button>
            
            <button id="all"
                @click="updateData('all')" :class="{active: selection==='all'}"
                >
                ALL
            </button>
            </div>
            <apexchart class="mt-4" height="240" :options="chartOptions" :series="series" ref="packets"></apexchart>
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
                    data: [],
                }],
                packets: [],
                chartOptions: {
                    chart: {
                        id: 'area-datetime',
                        type: 'area',
                        height: 350,
                        zoom: {
                            autoScaleYaxis: true
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        size: 0,
                        style: 'hollow',
                    },
                    xaxis: {
                        type: 'datetime',
                        min: new Date('01 May 2021').getTime(),
                        tickAmount: 6,
                    },
                    tooltip: {
                        x: {
                            format: 'dd MMM yyyy'
                        }
                    },
                    stroke: {
                        width: 1.5
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.9,
                            stops: [0, 100]
                        }
                    },
                }, 
                selection: 'todayss',
                year: new Date().getFullYear(),
                month: '',
                week: '',
                showyear: false,
                showmonth: false,
                showweek: false,
                type: 'Monthly'
            }
        },

        created(){
            this.listenForNewEvent();
            this.fetch();
            var d = new Date();

            d.setHours(d.getHours() - 2);
        },

        methods : {

            listenForNewEvent(){
                Echo.join('public-channel')
                .listen('PacketReceiver', (datas) => {
                    this.$parent.new(datas);
                    let x = datas.time;
                    let y = datas.gyro;
                    // (this.series[0].data.length > 50) ? this.series[0].data.splice(0, 1) : '';
                    this.series[0].data.push({x,y});
                    this.updateSeriesLine();
                });
            },

            updateSeriesLine(gyro) {
                this.$refs.packets.updateSeries([{
                    data: this.series[0].data,
                }], false, true);
            },

            fetch(){
                axios.get(this.currentUrl+'/api/packets')
                .then(response => {
                 
                    this.series[0].data = response.data.data;
                    this.updateSeriesLine();
                })
                .catch(err => console.log(err));
            },

            updateData: function(timeline) {
                this.selection = timeline
        
                switch (timeline) {
                    case 'todayss':
                        this.$refs.packets.zoomX(
                            new Date('1 May 2021').getTime(),
                            new Date('31 May 2021').getTime()
                        )
                        break
                    case 'six_months':
                        this.$refs.packets.zoomX(
                            new Date('27 Sep 2012').getTime(),
                            new Date('27 Feb 2013').getTime()
                        )
                        break
                    case 'one_year':
                        this.$refs.packets.zoomX(
                            new Date('1 Jan '+this.year).getTime(),
                            new Date('1 Jan '+parseInt(this.year+1)).getTime()
                        )
                        break
                    case 'ytd':
                        this.$refs.packets.zoomX(
                            new Date('01 Jan 2013').getTime(),
                            new Date('27 Feb 2013').getTime()
                        )
                        break
                    case 'all':
                        this.$refs.packets.zoomX(
                            new Date('23 Jan 2012').getTime(),
                            new Date('27 Feb 2013').getTime()
                        )
                        break
                    default:
                }
            }
        
        },

        components: { apexchart: VueApexCharts }
    }
</script>
