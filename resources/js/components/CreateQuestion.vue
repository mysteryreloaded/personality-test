<template>
    <div class="row justify-content-center">
        <h4 class="text-center mb-3">Create a question</h4>
        <div class="col-11 border-3 pb-3 pt-1 mb-3">
            <div class="form-group text-center p-1 pb-2">
                <label for="questionName">Question:</label>
                <input type="text" v-model="question.name" class="form-control" id="questionName" required>
            </div>
        </div>
        <div class="col-11 border-3 pb-3 pt-1 mb-3">
            <div class="form-group text-center p-1 pb-2">
                <label for="answerName0">Answer 1:</label>
                <div class="">
                    <input type="text" v-model="question.answers[0].name" class="form-control" id="answerName0" required>
                </div>
            </div>
            <div class="form-group text-center p-1 pb-2">
                <label for="introvertScore0">Introvert score (number from 0 to 3):</label>
                <div class="">
                    <input type="number"
                           @input="validateIntrovertScore(0)"
                           v-model="question.answers[0].introvertScore"
                           class="form-control"
                           id="introvertScore0"
                           required>
                </div>
            </div>
        </div>
        <div class="col-11 border-3 pb-3 pt-1 mb-3">
            <div class="form-group text-center p-1 pb-2">
                <label for="answerName1">Answer 2:</label>
                <input type="text"
                       v-model="question.answers[1].name"
                       class="form-control"
                       id="answerName1"
                       required>
            </div>
            <div class="form-group text-center p-1 pb-2">
                <label for="introvertScore1">Introvert score (number from 0 to 3):</label>
                <input type="number"
                       @input="validateIntrovertScore(1)"
                       v-model="question.answers[1].introvertScore"
                       class="form-control"
                       id="introvertScore1"
                       required>
            </div>
        </div>
        <div class="col-11 border-3 pb-3 pt-1 mb-3">
            <div class="form-group text-center p-1 pb-2">
                <label for="answerName2">Answer 3:</label>
                <input type="text" v-model="question.answers[2].name" class="form-control" id="answerName2" required>
            </div>
            <div class="form-group text-center p-1 pb-2">
                <label for="introvertScore2">Introvert score (number from 0 to 3):</label>
                <input type="number"
                       @input="validateIntrovertScore(2)"
                       v-model="question.answers[2].introvertScore"
                       class="form-control"
                       id="introvertScore2"
                       required>
            </div>
        </div>
        <div class="col-11 border-3 pb-3 pt-1 mb-3">
            <div class="form-group text-center p-1 pb-2">
                <label for="answerName3">Answer 4:</label>
                <input type="text" v-model="question.answers[3].name" class="form-control" id="answerName3" required>
            </div>
            <div class="form-group text-center p-1 pb-2">
                <label for="introvertScore3">Introvert score (number from 0 to 3):</label>
                <input type="number"
                       @input="validateIntrovertScore(3)"
                       v-model="question.answers[3].introvertScore"
                       class="form-control"
                       id="introvertScore3"
                       required>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-11 p-0">
            <div class="d-flex justify-content-between">
                <a :href="routes['index']" class="btn btn-outline-secondary pr-2 w-45">Back</a>
                <button @click="submit()" class="btn btn-outline-danger pl-2 w-45">Submit</button>
            </div>
        </div>
    </div>
    <notifications :speed="1000" position="bottom right"/>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';

    export default {
        name: 'CreateQuestions',
        props: {
            emptyQuestion: {
                type: Object,
                default: {}
            },
            routes: {
                type: Object,
                default: []
            }
        },
        data() {
            return {
                question: this.emptyQuestion,
                emptyQuestionCopy: _.cloneDeep(this.emptyQuestion),
                questionCounter: 1
            }
        },
        methods: {
            validate() {
                let hasError = false;

                if (this.question.name.trim() === '') {
                    hasError = true;
                }

                this.question.answers.forEach((answer) => {
                    if (answer.name.trim() === '' || answer.introvertScore === '') {
                        hasError = true;
                    }
                });

                return hasError;
            },
            submit() {
                if (this.validate()) {
                    this.$notify({
                        title: 'Couldn\'t save! ❌',
                        text: 'Please fill all fields and try again.',
                        type: 'error'
                    });
                    return;
                }

                let storeRoute = this.routes['store'];

                axios.post(storeRoute, {
                    questionData: JSON.stringify(this.question)
                }).then(function (response) {
                    if (response.data.success) {
                        this.$notify({
                            title: 'Save successful! ✅',
                            text: 'Question: `' + this.question.name + '` has been saved successfully!',
                            type: 'success'
                        });
                        this.question = _.cloneDeep(this.emptyQuestionCopy);
                        this.questionCounter++;
                        this.question.id = this.questionCounter;
                    }
                }.bind(this))
                    .catch(function (error) {
                        this.$notify({
                            title: 'Something went wrong! ❌',
                            text: 'An error occured. Please try again,',
                            type: 'error'
                        });
                    });
            },
            validateIntrovertScore(currentAnswer) {
                if (
                    this.question.answers[currentAnswer].introvertScore !== 0 &&
                    this.question.answers[currentAnswer].introvertScore !== 1 &&
                    this.question.answers[currentAnswer].introvertScore !== 2 &&
                    this.question.answers[currentAnswer].introvertScore !== 3
                ) {
                    this.question.answers[currentAnswer].introvertScore = '';
                }
            }
        }
    }
</script>
