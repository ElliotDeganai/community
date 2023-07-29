<template>
    <div class="relative" :class="[loading ? 'h-screen overflow-hidden' : '']">

        <!-- <transition name="navFade"> -->
        <navbar class="fixed z-60 w-full top-0" @toggleLateral="changeMobileNav"></navbar>
        <!-- </transition> -->
        <div @click="resetToggles()" class="">
            <article class="">
                <slot />
            </article>
        </div>
        <custom-footer @click="resetToggles()" class="">
        </custom-footer>

<!--
    <transition name="nav-mobile">
            <div v-if="mobileNav" @click="changeMobileNav" class="z-70 lg:hidden xl:hidden absolute w-full h-full bg-black opacity-75 top-0 ">

            </div>
        </transition>

        <transition name="nav-mobile">
            <div v-if="mobileNav" class="z-70 lg:hidden xl:hidden top-0 fixed w-3/5 h-full bg-white">
                <nav-bar-mob @toggleLateral="changeMobileNav"/>
            </div>
        </transition>


        <transition name="nav-mobile">
            <div v-if="communication" class="z-70 absolute w-full h-full bg-black opacity-75 top-0 " />
        </transition>

        <transition name="nav-mobile">
            <div v-if="communication" class="z-80 h-full w-full top-0 fixed flex flex-wrap justify-center items-stretch content-center">
                <com-window class="w-4/5 md:w-2/3 lg:w-2/3 xl:w-1/2 h-70 self-center"/>
            </div>
        </transition>


        <transition name="com">
            <div v-if="loading" class="z-80 w-full h-full top-0 left-0 absolute">
                <loading class="w-full h-full"/>
            </div>
        </transition>


        <transition name="terms">
            <terms class="fixed bottom-0 h-20 w-full" v-if="terms" @termsValidated="closeTerms" />
        </transition> -->
    </div>
</template>

<script>
import MenuList from '../Help/Icon/Menu.vue';
import UserList from '../Help/Icon/User.vue';
import Profiles from '../Help/Icon/Profiles.vue';
import Connexion from '../Help/Icon/Connexion.vue';
import Facebook from '../Help/Icon/Facebook.vue';
import Instagram from '../Help/Icon/Instagram.vue';
import Twitter from '../Help/Icon/Twitter.vue';
import Navbar from '../Help/Navbar.vue'
import CustomFooter from '../Help/Footer.vue'
export default {
    components: {
        MenuList,
        UserList,
        Profiles,
        Connexion, Facebook, Instagram, Twitter, Navbar, CustomFooter
    },
    data() {
        return {
            userPhoto: null,
            toggle_menu: false,
            toggle_login: false,
            mobileNav: false,
            scrollPosition: null,
        }
    },
    methods: {
        setToggle() {
            this.toggle_menu = !this.toggle_menu;
            if(this.toggle_login){
                this.toggle_login = false;
            }
        },
        setToggleLogin() {
            this.toggle_login = !this.toggle_login;
            if(this.toggle_menu){
                this.toggle_menu = false;
            }
        },
        changeMobileNav(){
            this.mobileNav = !this.mobileNav;
            if(this.mobileNav){
                this.textClass = 'h-screen overflow-hidden'
            }else{
                this.textClass = ''
            }
        },
    },
  computed: {
  },
    created(){
    },
    mounted(){
    }
}
</script>

<style>
.navbar {
    box-shadow: 0 0 10px 2px rgba(0, 0, 0, .2);
}

     .nav-mobile-enter-active{
        animation: nav-mobileInVisibility .4s linear, nav-mobileIn .4s linear;
    }

       .nav-mobile-leave-active, .nav-mobile-leave-to, .nav-mobile-leave{
        animation: nav-mobileOutVisibility .4s linear, nav-mobileOut .4s linear;
    }

     @keyframes nav-mobileIn{
        from{ transform: translateX(-100%); }
        to{ transform: translateX(0); }
    }
    @keyframes nav-mobileInVisibility{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes nav-mobileOut{
        from{ transform: translateX(0); }
        to{ transform: translateX(-100%); }

    }

    @keyframes nav-mobileOutVisibility{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }

     .navFade-enter-active{
        animation: navFadeInVisibility .4s linear, navFadeIn .4s linear;
        position: absolute;
        left: 0;
        right: 0;

        width: 100%;
    }

       .navFade-leave-active, .navFade-leave-to, .navFade-leave{
        animation: navFadeOutVisibility .4s linear, navFadeOut .4s linear;
        position: absolute !important;

        left: 0;
        right: 0;

        width: 100%;

    }

     @keyframes navFadeIn{
        from{ transform: translateY(-100%); }
        to{ transform: translateY(0); }
    }
    @keyframes navFadeInVisibility{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes navFadeOut{
        from{ transform: translateY(0); }
        to{ transform: translateY(-100%); }

    }

    @keyframes navFadeOutVisibility{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }


     .com-enter-active{
        animation: comInVisibility .4s linear;
    }

       .com-leave-active, .com-leave-to, .com-leave{
        animation: comOutVisibility .4s linear;
    }

     @keyframes comIn{
        from{ transform: translateY(100%); }
        to{ transform: translateY(0); }
    }
    @keyframes comInVisibility{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes comOut{
        from{ transform: translateY(0); }
        to{ transform: translateY(100%); }

    }

    @keyframes comOutVisibility{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }

       .terms-leave-active, .terms-leave-to, .terms-leave{
        animation: termsOutVisibility 1s linear, termsOut 1s linear;
    }

     @keyframes termsIn{
        from{ transform: translateY(100%); }
        to{ transform: translateY(0); }
    }
    @keyframes termsInVisibility{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes termsOut{
        from{ transform: translateY(0); }
        to{ transform: translateY(100%); }

    }

    @keyframes termsOutVisibility{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }

button:focus,
button:active,
a:focus,
a:active{
     outline: 0;
 }

body{
    font-family: 'Montserrat', sans-serif;
}

</style>
