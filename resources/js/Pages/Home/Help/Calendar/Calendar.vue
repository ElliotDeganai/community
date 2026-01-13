<template>
    <div>
        <Top @prevMonth="decreaseMonth()" @nextMonth="increaseMonth()" @resetCalendar="reset()" :getMonth="dynamicMonth" :getYear="dynamicYear" class="w-full h-1/8 py-4" />
        <Grid :getDays="getCurrentDays" :getSelectionDay="dynamicDay" @changeDay="changeDay" :getevents="getevents" class="w-full py-4 h-7/8" />
        <!-- <Create :getdate="dynamicDay" class="w-full" /> -->
    </div>
</template>
<script>
import Top from './Header.vue'
import Grid from './Grid.vue'
import Create from './Appointment/Create.vue'
export default {
    props: ["getevents"],
    components: {Top, Grid, Create},
    data() {
        return {
            month: this.getCurrentMonth(),
            year: this.getCurrentYear(),
            day: this.getCurrentDay()
        }
    },
    methods: {
        changeDay(day) {
            this.day = day;
        },
        reset() {
            this.month = this.getCurrentMonth();
            this.year = this.getCurrentYear();
            this.day = this.getCurrentDay();
        },
        decreaseMonth() {
            switch (this.month) {
                case 0:
                    this.month = 11;
                    this.year = this.year-1;
                    break;
                default:
                    this.month = this.month-1;
                    break;
            }
        },
        increaseMonth() {
            switch (this.month) {
                case 11:
                    this.month = 0;
                    this.year = this.year+1;
                    break;
                default:
                    this.month = this.month+1;
                    break;
            }
        },
        getCurrentYear() {
            let current = new Date();
            return current.getFullYear();
        },
        getCurrentMonth() {
            let current = new Date();
            return current.getMonth()
        },
        getCurrentDay() {
            let current = new Date();
            return current;
        },
        getDays(month, year) {
            let date = new Date(year, month, 1);
            let days = [];
            while (date.getMonth() === month) {
                days.push(new Date(date));
                date.setDate(date.getDate()+1);
            }
            return days;
        },

    },
    computed: {
        currentDate() {
            const current = new Date();
            const date = `${current.getDate()}/${current.getMonth()+1}/${current.getFullYear()}`;
            return date;
        },
        currentDateFull() {
            const current = new Date();
            return current;
        },
        dynamicMonth() {
            return this.month;
        },
        dynamicYear() {
            return this.year;
        },
        dynamicDay() {
            return this.day;
        },
        getCurrentDays() {
            return this.getDays(this.dynamicMonth, this.dynamicYear);
        },
    },
    mounted() {
    },
}
</script>
