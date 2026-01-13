<template>
    <div class="w-full">
        <div class="w-full flex flex-wrap justify-center content-center">
            <div
                v-for="day, index in days"
                :key="index"
                class="w-1/7 text-center font-bold"
            >{{ day }}</div>
        </div>
        <div class="flex flex-wrap py-4">
            <div :key="index" :class="[compareDates(date, this.getSelectionDay) ? 'bg-blue-200 border border-blue-900' : '']" class="flex flex-wrap justify-center content-center border w-1/7 h-32" v-for="date, index in currentDays">
                <div @click.prevent="selectDay(date)" class="cursor-pointer w-full h-full flex flex-wrap justify-center content-center">
                    <span :class="[isToday(date) ? 'text-blue-600' : '' ]" class="py-2 px-2" v-if="date !== null">{{ date.getDate() }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["getDays", "getSelectionDay", "getevents"],
    data() {
        return {
            days: [ 'sun' ,'mon', 'tue', 'wed', 'thu', 'fri', 'sat' ],
            //selectedDay: this.getSelectionDay,
        }
    },
    methods: {
        compareDates(day1, day2) {
            if (this.onlyDate(day1) > this.onlyDate(day2)) {
                //console.log('The date is superior');
                return false;
            } else if (this.onlyDate(day1) < this.onlyDate(day2)) {
                //console.log('The date is inferior');
                return false;
            } else {
                //console.log('The date are equals');
                return true;
            }
        },
        isToday(day) {
            if (this.onlyDate(day) > this.onlyDate(new Date())) {
                //console.log('The date is superior');
                return false;
            } else if (this.onlyDate(day) < this.onlyDate(new Date())) {
                //console.log('The date is inferior');
                return false;
            } else {
                //console.log('The date are equals');
                return true;
            }
        },
        selectDay(day) {
            //console.log(day);
            //this.selectedDay = day;
            this.$emit('changeDay', day);
        },
        onlyDate(day) {
            const current = new Date(day);
            const date = `${current.getDate()}/${current.getMonth()+1}/${current.getFullYear()}`;
            return date;
        },
    },
    computed: {
        currentDays() {
            let monthOffset = this.getDays[0].getDay();
            let currentDays = [];
            for (let index = 0; index < monthOffset; index++) {
                currentDays.push(null);
            }
            this.getDays.forEach(element => {
                currentDays.push(element);
            });
            return currentDays;
        }
    },
    mounted() {
    },
}
</script>
