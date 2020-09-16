<template>
    <div>
        <FullCalendar
            ref="fullCalendar"
            :options="calendarOptions"
        ></FullCalendar>
    </div>
</template>

<script>
    import FullCalendar from "@fullcalendar/vue";
    import dayGridPlugin from "@fullcalendar/daygrid";
    import timeGridPlugin from "@fullcalendar/timegrid";
    import interactionPlugin from "@fullcalendar/interaction";
    import listPlugin from "@fullcalendar/list";
    import ruLocale from '@fullcalendar/core/locales/ru';

    import "@fullcalendar/daygrid/main.css"
    import "@fullcalendar/timegrid/main.css"


    export default {
        name: "Calendar",
        components: {
            FullCalendar,
        },
        data() {
            return {

                calendarOptions: {
                    initialView: 'listWeek',
                    locale: ruLocale,
                    plugins: [
                        dayGridPlugin,
                        timeGridPlugin,
                        interactionPlugin,
                        listPlugin
                    ],
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'listYear'
                    },
                    events: [
                        {
                            title: 'Meeting',
                            start: '2020-08-12T14:30:00',
                            extendedProps: {
                                status: 'done'
                            }
                        },
                        {
                            title: 'Birthday Party',
                            start: '2020-08-13T07:00:00',
                            backgroundColor: 'green',
                            borderColor: 'green'
                        }
                    ]
                }
            }
        }
    }
</script>

<style scoped>

</style>
