<template>
    <div class="d-flex justify-content-between">
        <span class="text-black-50 mb-2">Question {{ (currentQuestion + 1) }}/{{ questions.length }}</span>
        <button @click="this.$emit('back-to-menu')" class="btn btn-outline-secondary pr-2">Quit</button>
    </div>
    <h3 class="mt-3">{{ questions[currentQuestion].name }}</h3>
    <span class="text-black-50 fst-italic font-sm">All questions are required</span>

    <ul class="mt-4 p-0 fix-ul">
        <li class="mb-2 list-item" :class="answer.selected === true ? 'list-item-selected fade-in' : ''" v-for="(answer, index) in questions[currentQuestion].answers" @click="selectAnswer(answer.id)">
            <input class="hidden" type="radio" name="answer[0]" :value="answer.id" :id="'question_' + currentQuestion + '_answer_' + answer.id">
            <div class="d-flex align-items-center">
                <span class="py-1 px-2 mr-2 badge-square" :class="answer.selected === true ? 'badge-square-selected' : ''">{{ String.fromCharCode(65 + index) }}</span>
                <div class="flex-grow-1">
                    <span :class="answer.selected === true ? 'text-bold' : ''">{{ answer.name }}</span>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        name: 'Questions',
        props: {
            questionsData: {
                type: Array,
                default: []
            },
            currentQuestion: {
                type: Number,
                default: null
            }
        },
        data() {
            return {
                questions: this.questionsData,
            }
        },
        computed: {
            isAnswerSelected() {
                return this.questions[this.currentQuestion].answers.some((answer) => answer.selected === true);
            },
        },
        methods: {
            selectAnswer(answerId) {
                this.questions[this.currentQuestion].answers.forEach((answer) => {
                    answer.selected = answer.id === answerId;
                });
            }
        }
    }
</script>
