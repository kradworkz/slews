<template>
<div>
    <div class="search-box chat-search-box py-4">
        <div class="position-relative">
            <input type="text" class="form-control" placeholder="Search...">
        <i class="bx bx-search-alt search-icon"></i>
        </div>
    </div>

    <div class="chat-leftsidebar-nav" v-for="(list,index) in packets" v-bind:key="list.id">
        <div class="mt-2">
            <div class="card border shadow-none mb-2">
                <a href="javascript: void(0);" class="text-body">
                    <div class="p-2">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <p class="text-muted text-truncate mb-0"><span class="font-size-11">Date: {{list.time}}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="overflow-hidden mr-auto">
                                        <p class="text-muted text-truncate mb-0"><span class="font-size-10">Accelerometer:</span> {{list.accelerometer}}</p>
                                        <p class="text-muted text-truncate mb-0"><span class="font-size-10">Gyro:</span> {{list.gyro}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="overflow-hidden mr-auto">
                                        <p class="text-muted text-truncate mb-0"><span class="font-size-10">SoilMoisture:</span> {{list.soilmoisture}}</p>
                                        <p class="text-muted text-truncate mb-0"><span class="font-size-10">Temperature:</span> {{list.temperature}}</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </a>
            </div>           
        </div>

    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            packets: []
        }
    },

    created(){
    },

    methods : {
        newPackets(data){
            this.packets.unshift(data);
        }
    }
}
</script>>