<template>
    <div class="row">
        <div class="container">
            <div class="jumbotron">
                <h1>Log meeting</h1>
                <div class="row">
                    <form class="form" @submit.prevent="handleForm">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" :class="{'has-error': errors.has('roomName') }">
                                    <label>Room name</label>
                                    <input type="text"
                                           name="roomName"
                                           v-validate:roomName="'required'"
                                           class="form-control"
                                           v-model="roomName"
                                    >
                                    <span class="text-danger help-block" v-if="errors.has('roomName')">{{ errors.first('roomName') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" :class="{'has-error': errors.has('from') }">
                                    <label>From</label>
                                    <input type="text"
                                           name="from"
                                           v-validate:from="'required|date_format:DD/MM/YYYY H:mm'"
                                           class="form-control"
                                           v-model="from"
                                           placeholder="DD/MM/YYYY H:mm"
                                    >
                                    <span class="text-danger help-block" v-if="errors.has('from')">{{ errors.first('from') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" :class="{'has-error': errors.has('to') }">
                                    <label>To</label>
                                    <input type="text"
                                           name="to"
                                           v-validate:to="'required|date_format:DD/MM/YYYY H:mm|after:from'"
                                           class="form-control"
                                           placeholder="DD/MM/YYYY H:mm"
                                           v-model="to"
                                    >
                                    <span class="text-danger help-block" v-if="errors.has('to')">{{ errors.first('to') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success pull-right">Log!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import moment from 'moment';
    import { Validator } from 'vee-validate';

    Validator.installDateTimeValidators(moment);

    export default {
        methods: {
            handleForm: function () {
                this.$validator.validateAll();
                if (!this.errors.any()) {
                    axios.post('/log', {
                        name: this.roomName,
                        from: this.from,
                        to:   this.to
                    }).then(function(response){
                        alert('Saved');
                    }).catch(function(error){
                        alert('Error: '+ error)
                    });
                }
            }
        },
        data: function () {
            return {
                roomName: '',
                from: '',
                to: ''
            }
        }
    }
</script>