<template>
    <div class="row">
        <div class="container">
            <div class="jumbotron">
                <h1>Statistics</h1>
                <div class="row">
                    <table class="table">
                        <tr>
                            <th>Room Name</th>
                            <th>Todays Load</th>
                        </tr>
                        <tr v-for="room in rooms">
                            <td>{{ room.name }}</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                         role="progressbar"
                                         v-bind:aria-valuenow="room.occupancy"
                                         aria-valuemin="0"
                                         aria-valuemax="100"
                                         v-bind:style="{width: room.occupancy+'%'}"
                                    >
                                        <span class="sr-only">{{ room.occupancy }}</span>
                                        {{ room.occupancy }}%
                                    </div>
                                </div>
                                </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function() {
                return {
                    rooms: []
                }
        },

        mounted: function () {
            axios.get("/log")
                .then(response => {
                    this.rooms = response.data;
                })
        }
    }
</script>