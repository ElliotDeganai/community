<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Edit a user</div>
            </div>
        </div>
        <div>From this page you can edit your user</div>
        <div>
            <div>
                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                <div>
                    <div class="py-2">
                        <form @submit.prevent="submit">
                            <div>
                                <div>
                                    <div class="header-config">
                                        Edit {{form.user.name}}
                                    </div>
                                    <form class="py-8" @submit.prevent="submit">
                                        <div class="flex flex-wrap">
                                            <div class="py-4 w-1/3">
                                                <div class="label-fields">Name</div>
                                                <input type="text" class="form-fields" id="name" name="name" v-model="form.name" />
                                            </div>
                                            <div class="py-4 w-1/3">
                                                <div class="label-fields">Email</div>
                                                <input type="email" class="form-fields" id="email" name="email" v-model="form.email" />
                                            </div>
<!--                                             <div class="py-4 w-1/3">
                                                <div class="label-fields">City</div>
                                                <input type="text" class="form-fields" id="city" name="city" v-model="form.city" />
                                            </div>
                                            <div class="py-4 w-1/3">
                                                <div class="label-fields">Address</div>
                                                <input type="text" class="form-fields" id="address" name="address" v-model="form.address" />
                                            </div>
                                            <div class="py-4 w-1/3">
                                                <div class="label-fields">Zip Code</div>
                                                <input type="text" class="form-fields" id="zip_code" name="zip_code" v-model="form.zip_code" />
                                            </div> -->
<!--                                             <div class="py-4 w-1/3">
                                                <label class="label-fields">
                                                    Has company ?
                                                </label>
                                                <div v-if="form.id" class="py-2">
                                                    <div @click.prevent="toggleCompany()" :class="[form.has_company ? ' bg-green-300' : ' bg-stone-300']" class="cursor-pointer w-16 h-6 rounded-full relative shadow-lg">
                                                        <span :class="[form.has_company ? 'right-0 bg-green-800' : 'left-0 bg-stone-700']" class="absolute -top-1  w-8 h-8 rounded-full shadow-lg"></span>
                                                    </div>
                                                </div>
                                                <div v-else class="py-2">
                                                    <div @click.prevent="toggleCompany()" :class="[form.has_company ? ' bg-green-300' : ' bg-stone-300']" class="cursor-pointer w-16 h-6 rounded-full relative shadow-lg">
                                                        <span :class="[form.has_company ? 'right-0 bg-green-800' : 'left-0 bg-stone-700']" class="absolute -top-1  w-8 h-8 rounded-full shadow-lg"></span>
                                                    </div>
                                                </div>
                                            </div> -->
  <!--                                          <div class="py-8 w-full">
                                                <div class="header-config">
                                                    RSVP
                                                </div>
                                                <div>
                                                    <div>
                                                        <div class="py-4">
                                                            <label class="label-fields">
                                                                Will come to the party ? <span v-if="form.is_partying == 0">No</span> <span v-else>Yes</span>
                                                            </label>
                                                        </div>
                                                        <div v-if="form.has_company" class="py-4">
                                                            <label class="label-fields">
                                                                Will be accompanied ? <span v-if="form.is_accompanied == 0">No</span> <span v-else>Yes</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                     <div v-else>
                                                        <div class="py-4">
                                                            <div class="border border-stone-700 rounded-lg p-8">The RSVP was not answered yet.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->
                                        </div>
                                        <div class="py-8">
                                            <div class="header-config">
                                                Roles
                                            </div>
                                            <div class="flex flex-wrap">
                                                <div class="checkbox py-4 w-1/5" :key="role.id" v-for="role in all_roles">
                                                    <label class="label-fields">
                                                        <input type="checkbox" :name="'roles'+role.id" :value="role"
                                                        @change="CheckRole(role)" :checked="isChecked(role)"/>
                                                        {{role.name}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
<!--                                         <div>
                                            <div class="header-config">
                                                Calendrier
                                            </div>
                                            <div>
                                                <div class="flex flex-wrap">
                                                    <div v-if="form.calendar.slot_duration_unit !== 'D'" class="py-4 w-1/3">
                                                        <div class="label-fields">Heure de Début</div>
                                                        <input type="time" class="form-fields" id="beginning_hour" name="beginning_hour" v-model="form.calendar.beginning_hour" />
                                                    </div>
                                                    <div v-if="form.calendar.slot_duration_unit !== 'D'" class="py-4 w-1/3">
                                                        <div class="label-fields">Heure de Fin</div>
                                                        <input type="time" class="form-fields" id="ending_hour" name="ending_hour" v-model="form.calendar.ending_hour" />
                                                    </div>
                                                    <div class="py-4 w-1/3">
                                                        <div class="label-fields">Durée du créneau</div>
                                                        <input type="text" class="form-fields" id="slot_duration_time" name="slot_duration_time" v-model="form.calendar.slot_duration_time" />
                                                    </div>
                                                    <div class="py-4 w-1/3">
                                                        <div class="label-fields">Disponibilité</div>
                                                        <input type="text" class="form-fields" id="availability_type" name="availability_type" v-model="form.calendar.availability_type" />
                                                    </div>
                                                    <div class="py-4 w-1/3">
                                                        <div class="label-fields">Unité du créneau</div>
                                                        <input type="text" class="form-fields" id="slot_duration_unit" name="slot_duration_unit" v-model="form.calendar.slot_duration_unit" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="">
                                            <button class="btn-submit-fields" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from '../../../Layouts/Authenticated.vue';
import { reactive } from 'vue'
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
//import { useForm } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3";
export default {
    layout: Layout,
    components: {},
    setup(props) {
        const form = useForm({
            id: props.getuser.id,
            user: props.getuser,
            name: props.getuser.name,
            email: props.getuser.email,
            city: props.getuser.city,
            address: props.getuser.address,
            zip_code: props.getuser.zip_code,
            has_company: props.getuser.has_company,
            is_accompanied: props.getuser.is_accompanied,
            is_partying: props.getuser.is_partying,
            calendar: props.getuser.calendar ? props.getuser.calendar : null,
            roles: [],
        });
        return { form };
    },
    data() {
        return {
            all_roles: this.getroles,
            has_calendar: false
        }
    },
    props: {
        getuser: Object,
        getroles: Object,
        errors: Object,
    },
    methods: {
        submit() {
            this.form.put(route("users.update", this.getuser.id));
        },
        isChecked(role) {
            //console.log(this.form.roles.find(roleU => roleU.id === role.id) !== undefined, role.name)
            return this.form.roles.find(roleU => roleU === role.id) !== undefined;
        },
        CheckRole(role) {
            this.form.roles.find(roleU => roleU === role.id) === undefined ?
            this.form.roles.push(role.id) : this.form.roles.splice(this.form.roles.indexOf(role.id), 1);
        },
        toggleCompany() {
            this.form.has_company = !this.form.has_company;
        },
        setCalendar() {
            if (!this.getuser.calendar) {
                this.form.calendar = {
                    beginning_hour: '09:00:00',
                    ending_hour: '19:00:00',
                    slot_duration_time: null,
                    availability_type: null,
                    slot_duration_unit: 'D',
                    user: null
                };
            }
        },
    },
    created() {
        this.setCalendar();
        if (this.getuser.calendar) {
            this.has_calendar = true;
        }
    },
    mounted() {
        for (let index = 0; index < this.form.user.roles.length; index++) {
            const element = this.form.user.roles[index];
            this.form.roles.push(this.form.user.roles[index].id);
        }
    },
}
</script>
