<template>
    <div class="">
        <div class="w-full flex flex-wrap justify-start relative py-4">
            <div class="absolute left-0 top-0">
                <p class="text-xl">{{getYear}}</p>
            </div>
            <div class="absolute right-0 top-0">
                <p class="px-3 cursor-pointer bg-teal-400 rounded-full" @click.prevent="resetCalendar()">Reset</p>
            </div>
        </div>
        <div class="wrapper w-full relative">
            <div class="absolute top-0 left-0">
                <div class="cursor-pointer" @click.prevent="prevMonth()">
                    <Left :getSize="6" />
                </div>
            </div>
            <div class="font-bold w-full">
                <h2 class="text-center w-full uppercase">{{month}}</h2>
            </div>
            <div class="absolute top-0 right-0">
                <div class="cursor-pointer" @click.prevent="nextMonth()">
                    <Right :getSize="6" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Left from '../Icon/Left.vue'
import Right from '../Icon/Right.vue'
export default {
    components:  {Left, Right},
    props: ['getMonth', 'getYear'],
    data() {
        return {
        }
    },
    methods: {
        resetCalendar() {
            this.$emit('resetCalendar');
        },
        nextMonth() {
            this.$emit('nextMonth');
        },
        prevMonth() {
            this.$emit('prevMonth');
        },
        getDisplayMonth(month) {
            switch (month) {
                case 0:
                    return 'January';
                    break;
                case 1:
                    return 'February';
                    break;
                case 2:
                    return 'March';
                    break;
                case 3:
                    return 'April';
                    break;
                case 4:
                    return 'May';
                    break;
                case 5:
                    return 'June';
                    break;
                case 6:
                    return 'July';
                    break;
                case 7:
                    return 'August';
                    break;
                case 8:
                    return 'September';
                    break;
                case 9:
                    return 'October';
                    break;
                case 10:
                    return 'November';
                    break;
                case 11:
                    return 'December';
                    break;

                default:
                    break;
            }
        }
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
        month() {
            return this.getDisplayMonth(this.getMonth);
        },
    }

}
</script>
