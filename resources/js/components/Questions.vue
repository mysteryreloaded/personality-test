<template>
    <div class="row justify-content-center bg-welcome py-5">
        <div class="col-md-8">
            <div class="well">
                <span class="text-black-50 mb-2">Question {{ $route.params.id }}/{{ question.totalQuestions }}</span>
                <h3 class="mt-3">{{ question.question }}</h3>
                <span class="text-black-50 fst-italic font-sm">All questions are required</span>

                <ul class="mt-4 p-0 fix-ul">
                    <li class="mb-2 list-item" :class="answer.selected === true ? 'list-item-selected' : ''" v-for="(answer, index) in question.answers" @click="selectAnswer(answer.id)">
                        <input class="hidden" type="radio" name="answer[0]" :value="answer.id" :id="'question_' + $route.params.id + '_answer_' + answer.id">
                        <label>
                            <span class="py-1 px-2 mr-2 badge-square" :class="answer.selected === true ? 'badge-square-selected' : ''">{{ String.fromCharCode(65 + index) }}</span>
                            <span>{{ answer.answer }}</span>
                        </label>
                    </li>
                </ul>

                <button type="button" class="btn btn-primary rounded w-100">
                    <span>Next question
                        <svg width="16" height="16" fill="currentColor" class="bi bi-chevron-right d-inline" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Questions',
    props: {
        questionData: {
            type: Object,
            default: function () {
                return {
                    id: 1,
                    question: 'You’re really busy at work and a colleague is telling you their life story and personal woes. You:',
                    totalQuestions: 5,
                    answers: [
                        {
                            id: 1,
                            answer: 'Don’t dare to interrupt them',
                        },
                        {
                            id: 2,
                            answer: 'Think it’s more important to give them some of your time; work can wait',
                        },
                        {
                            id: 3,
                            answer: 'Listen, but with only with half an ear',
                        },
                        {
                            id: 4,
                            answer: 'Interrupt and explain that you are really busy at the moment',
                        }
                    ]
                }
            },
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    data() {
        return {
            question: this.questionData
        }
    },
    methods: {
        selectAnswer(answerId) {
            this.question.answers.forEach((answer) => {
                answer.selected = answer.id === answerId;
            });
        }
    }
}
</script>
