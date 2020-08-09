<template>
    <section class="login-section">
        <transition name="slide" mode="out-in">
            <component :is="form" @showform="form = $event"></component>
        </transition>
    </section>
</template>

<script>
    import LoginForm from "./LoginCards/LoginForm";


    export default {
        name: "LoginFormCards",
        components: {
            'LoginForm': LoginForm
        },
        data() {
            return {
                form: 'LoginForm'
            }
        }
    }
</script>

<style scoped>
    .slide-enter-active, .slide-leave-active{
        transition: transform .5s ease-out;
    }

     .slide-enter, .slide-leave-to  {
         transform: translateX(100%);
     }
    .slide-enter-to, .slide-leave {
        transform: translateX(0);
    }


</style>
