export default {
    configRouter: function (router) {

        router.map({
            '/': {
                component: require('./pages/MeetingRoom.vue')
            }
        });

    }
}
