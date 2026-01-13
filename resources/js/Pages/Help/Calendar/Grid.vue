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
            <div :key="index" :class="[compareDates(date, this.getSelectionDay) ? 'bg-teal-200 border border-teal-900' : '']" class="flex flex-wrap justify-center content-center border w-1/7 h-32" v-for="date, index in currentDays">
                <div class="relative w-full h-full">
                     <div v-if="!dateIsOld(date) && isTrainerAvailability(date) && !isOccupied(date)" @click.prevent="selectDay(date)" class="cursor-pointer w-full h-full flex flex-wrap justify-center content-center">
                        <span @click.prevent="selectDay(date)" :class="[isToday(date) ? 'text-teal-600' : '' ]" class="py-2 px-2" v-if="date !== null">{{ date.getDate() }}</span>
                    </div>
                    <div v-else class="absolute top-0 left-0 w-full h-full bg-teal-900 text-white opacity-50 flex flex-wrap justify-center content-center">
                        <span class="py-2 px-2" v-if="date !== null">{{ date.getDate() }}</span>
                    </div>
<!--                     <div class="absolute top-0 left-0 w-full h-full flex flex-wrap justify-center content-center">
                        <span class="py-2 px-2" v-if="date !== null">{{ date.getDate() }}</span>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["getDays", "getSelectionDay", "getevents", "getoccupied", "getcalendar"],
    data() {
        return {
            days: [ 'sun' ,'mon', 'tue', 'wed', 'thu', 'fri', 'sat' ],
            //selectedDay: this.getSelectionDay,
            //trainer_calendar: this.getcalendar
        }
    },
    methods: {
        isOccupied(date) {
            let date_occ = this.getoccupied.filter(elt => this.compareDates(elt.meeting_date, date))[0];
            if (date_occ) {
                return true;
            } else {
                return false;
            }
        },
        getNbOfEvents(date) {
            let date_occ = this.getoccupied.filter(elt => this.compareDates(elt.doc_values[0].value_date_time, date));
            return date_occ.length;
        },
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
        dateIsOld(day) {
            if (day) {
                let today = new Date();
                if (day.getFullYear() == today.getFullYear()) {
                    if (day.getMonth() == today.getMonth()) {
                        if (today.getDate() < day.getDate()) {
                            //console.log('The date day is superior, so date superior to today');
                            return false;
                        } else {
                            //console.log('The date day is inferior, so date inferior to today');
                            return true;
                        }
                    }else if (today.getMonth() < day.getMonth()) {
                        //console.log('The date month is inferior, so date inferior to today');
                        return false;
                    } else {
                        //console.log('The date month is superior, so date superior to today');
                        return true;
                    }
                } else if (today.getFullYear() < day.getFullYear()) {
                    //console.log('The date year is inferior, so date inferior to today');
                    return false;
                } else {
                    //console.log('The date year is superior, so date superior to today');
                    return true;
                }
            }
        },
        dateIsOlder(day, ref_day) {
            if (day) {
                let today = new Date(ref_day);
                if (day.getFullYear() == today.getFullYear()) {
                    if (day.getMonth() == today.getMonth()) {
                        if (today.getDate() < day.getDate()) {
                            //console.log('The date day is superior, so date superior to today');
                            return false;
                        } else {
                            //console.log('The date day is inferior, so date inferior to today');
                            return true;
                        }
                    }else if (today.getMonth() < day.getMonth()) {
                        //console.log('The date month is inferior, so date inferior to today');
                        return false;
                    } else {
                        //console.log('The date month is superior, so date superior to today');
                        return true;
                    }
                } else if (today.getFullYear() < day.getFullYear()) {
                    //console.log('The date year is inferior, so date inferior to today');
                    return false;
                } else {
                    //console.log('The date year is superior, so date superior to today');
                    return true;
                }
            }
        },
        isTrainerAvailability(date){
            let d = new Date(date);
            let date_day = d.getDay();
            switch (date_day) {
                case 0:
                    if (this.trainer_calendar.sunday == 0 || this.isTrainerOff(date)) {
                       return false;
                    }else {
                        return true;
                    }
                    break;
                case 1:
                    if (this.trainer_calendar.monday == 0 || this.isTrainerOff(date)) {
                       return false;
                    }else {
                        return true;
                    }
                    break;
                case 2:
                    if (this.trainer_calendar.tuesday == 0 || this.isTrainerOff(date)) {
                       return false;
                    }else {
                        return true;
                    }
                    break;
                case 3:
                    if (this.trainer_calendar.wednesday == 0 || this.isTrainerOff(date)) {
                       return false;
                    }else {
                        return true;
                    }
                    break;
                case 4:
                    if (this.trainer_calendar.thursday == 0 || this.isTrainerOff(date)) {
                       return false;
                    }else {
                        return true;
                    }
                    break;
                case 5:
                    if (this.trainer_calendar.friday == 0 || this.isTrainerOff(date)) {
                       return false;
                    }else {
                        return true;
                    }
                    break;
                case 6:
                    if (this.trainer_calendar.saturday == 0 || this.isTrainerOff(date)) {
                       return false;
                    }else {
                        return true;
                    }
                    break;

                default:
                    break;
            }
        },
        isTrainerOff(date){
            let d = new Date(date);
            let date_day = d.getDay();
            let return_date = new Date(this.trainer_calendar.return_date)
            if (this.trainer_calendar.is_off) {
                return this.dateIsOlder(date, this.trainer_calendar.return_date);
            }else {
                return false;
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
        setCurrentDay() {
            const current = new Date();
            //let d = new Date(this.getSelectionDay);
            let d = new Date(current);
            while (this.dateIsOld(d) || !this.isTrainerAvailability(d)) {
                d.setDate(d.getDate() + 1);
            }
            //const current_date = `${d.getDate()}/${d.getMonth()+1}/${d.getFullYear()}`;
            //return current_date;

            this.$emit('changeDay', d);
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
        },
        trainer_calendar() {
            return this.getcalendar;
        },
    },
    watch: {
        // Watch sur la prop (simple)
        getcalendar(newValue, oldValue) {
            this.oldValue = oldValue
            this.maPropChanged = true
            //console.log(`maProp a changé de ${oldValue} à ${newValue}`)
            this.setCurrentDay();

            // Ici tu peux faire n’importe quoi : appel API, mise à jour locale, etc.
        },
    },
    mounted() {
        this.setCurrentDay();
    },
}
</script>
