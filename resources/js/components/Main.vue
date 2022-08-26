<template>
    <div class="text-center" v-if="isTestFinished && this.introvertScore !== null">
        <h3 class="mb-5">Test is finished!</h3>
        <h5 class="mb-4">Your introvert score is: {{ this.introvertScore }}</h5>
        <div class="text-center mt-5">
            <h5 class="btn btn-outline-danger" @click="resetTest()">Try again?</h5>
        </div>
    </div>
    <div v-else-if="isTestStarted">
        <questions @back-to-menu="resetTest()" :questions-data="questions" :current-question="currentQuestion"></questions>
        <div class="d-flex">
            <nav-button
                :nav-button="navButtonPrevious"
                v-if="currentQuestion !== 0"
                @nav-button-click="previousQuestion"
            ></nav-button>
            <nav-button
                v-if="currentQuestion !== (questions.length - 1)"
                :nav-button="navButtonNext"
                :disabled="!isAnswerSelected"
                @nav-button-click="nextQuestion"
            ></nav-button>
            <nav-button
                v-else
                :nav-button="navButtonFinish"
                :disabled="!isAnswerSelected"
                @nav-button-click="nextQuestion"
            ></nav-button>
        </div>
    </div>
    <div v-else class="row justify-content-center">
        <div class="col-11 col-md-12">
            <div class="well p-5">
                <h4 class="text-center">Are you up for a short personality test?</h4>

                <div class="text-center mt-5 d-flex flex-column">
                    <span class="btn btn-outline-danger m-1" @click="startTest()">Yes, let's start!</span>
                    <a :href="routes['create']" class="btn btn-outline-danger m-1">Create new question/answers</a>
                    <span @click="destroyQuestions()" class="btn btn-outline-danger m-1">Delete all my questions</span>
                </div>
            </div>
        </div>
    </div>
    <notifications :speed="1000" position="top right"/>
</template>

<script>
    import Questions from './Questions.vue';
    import Button from './buttons/NavButton.vue';
    import axios from 'axios';
    import _ from 'lodash';
    import navButtonNext from './buttons/options/navButtonNext.json';
    import navButtonPrevious from './buttons/options/navButtonPrevious.json';
    import navButtonFinish from './buttons/options/navButtonFinish.json';

    export default {
        name: 'Main',
        components: {
            Questions,
            Button,
        },
        props: {
            questionsData: {
                type: Array,
                default: []
            },
            routes: {
                type: Object,
                default: {}
            }
        },
        data() {
            return {
                questions: this.questionsData,
                isTestStarted: false,
                isTestFinished: false,
                introvertScore: null,
                currentQuestion: 0,
                emptyQuestions: _.cloneDeep(this.questionsData),
                navButtonNext: navButtonNext,
                navButtonFinish: navButtonFinish,
                navButtonPrevious: navButtonPrevious
            }
        },
        computed: {
            isAnswerSelected() {
                return this.questions[this.currentQuestion].answers.some((answer) => answer.selected === true);
            },
        },
        methods: {
            startTest() {
                axios.get(this.routes.index).then(function (response) {
                    if (response.data.success) {
                        this.questions = response.data.questions;
                        this.isTestStarted = true;
                    }
                }.bind(this))
                    .catch(function () {
                        this.$notify({
                            title: 'Something went wrong! ❌',
                            text: 'An error occured. Please refresh the page and try again.',
                            type: 'error'
                        });
                    });
            },
            resetTest() {
                this.isTestStarted = false;
                this.isTestFinished = false;
                this.questions = _.cloneDeep(this.emptyQuestions);
                this.introvertScore = null;
                this.currentQuestion = 0;
            },
            destroyQuestions() {
                axios.post(this.routes['destroy']).then(function (response) {
                    if (response.data.success) {
                        this.$notify({
                            title: 'All questions deleted successfully! ✅',
                            text: 'You have no questions saved at the moment.',
                            type: 'success'
                        });
                    }
                }.bind(this))
                    .catch(function () {
                        this.$notify({
                            title: 'Something went wrong! ❌',
                            text: 'An error occured. Please refresh the page and try again.',
                            type: 'error'
                        });
                    });
            },
            finishTest() {
                axios.post(this.routes['finish']).then(function (response) {
                    if (response.data.success && typeof response.data.introvertPercent !== 'undefined') {
                        this.isTestFinished = true;
                        this.introvertScore = response.data.introvertPercent;
                        this.$notify({
                            title: 'Test completed! 🏁',
                            text: 'Hope you had fun!',
                            type: 'success'
                        });
                    }
                }.bind(this))
                    .catch(function () {
                        this.$notify({
                            title: 'Something went wrong! ❌',
                            text: 'An error occured. Please refresh the page and try again.',
                            type: 'error'
                        });
                });
            },
            nextQuestion() {
                let answerData = this.questions[this.currentQuestion].answers.filter((answer) => {
                    return answer.selected;
                });

                if (answerData.length < 1) {
                    return;
                } else {
                    answerData = answerData[0];
                }

                let storeRoute = this.routes['store'].replace('_ID_', this.questions[this.currentQuestion].id);

                axios.post(storeRoute, {
                    answerData: JSON.stringify(answerData)
                }).then(function (response) {
                    if (response.data.success) {
                        if (this.currentQuestion === (this.questions.length - 1)) {
                            this.finishTest();
                        } else {
                            this.$notify({
                                title: 'Answer saved! ✅',
                                text: 'Your answer `' + answerData.name + '` has been saved successfully!',
                                type: 'success'
                            });
                            this.currentQuestion++;
                        }
                    }
                }.bind(this))
                    .catch(function () {
                        this.$notify({
                            title: 'Something went wrong! ❌',
                            text: 'An error occured. Please refresh the page and try again.',
                            type: 'error'
                        });
                });
            },
            previousQuestion() {
                this.currentQuestion--;
            }
        }
    }
</script>
