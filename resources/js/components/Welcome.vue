<template>
    <router-view v-if="isTestStarted"></router-view>
    <div v-else class="row justify-content-center bg-welcome py-5">
        <div class="col-md-8">
            <div class="well">
                <div class="text-center">Are you an introvert?</div>

                <div class="text-center">
                    <router-link to="/questions/1" @click="isTestStarted = true">Let's find out!</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Welcome',
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                isTestStarted: false
            }
        }
    }
</script>
