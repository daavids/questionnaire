<template>
    <spinner-component v-if="showSpinner"></spinner-component>
    <div v-else>
        <div v-if="answers.length">
            <h2 class="my-5">{{ question }}</h2>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mx-auto my-5"
                    v-for="answer in answers" :key="answer.id">
                    <button class="btn btn-primary btn-lg w-100"
                        @click="submitAnswer(answer.id)">{{ answer.answer }}
                    </button>
                </div>
            </div>
            <div class="progress mt-5" style="height: 30px">
                <div class="progress-bar progress-bar-striped px-3" role="progressbar"
                    aria-valuemin="0" aria-valuemax="100"
                    :aria-valuenow="progress" :style="progress > 0 ? 'width: '+progress+'%' : ''">
                    {{ progress }}% ({{ questionsAnswered }}/{{ test.questions.length }})
                </div>
            </div>
        </div>
        <div v-else>
            <h4>Test is currently unavailable.</h4>
        </div>
    </div>
</template>

<script>

import Spinner from './Spinner.vue';
import qs from 'qs';

export default {
    props: [ 'testprop' ],
    data() {
        return {
            test: null,
            currentQuestion: 0,
            answers: [],
            question: "",
            questionID: null,
            showSpinner: true,
            completed: false,
            questionsAnswered: 0
        }
    },
    mounted() {
        this.test = JSON.parse(this.$props.testprop);
        this.getQuestion();
    },
    methods: {
        getQuestion() {
           
            this.showSpinner = true;
           
            this.$http.get('/tests/'+this.test.id+'/questions')
                .then((response) => {
                    
                    if (response.data.data.questionsAnswered == this.test.questions.length) {
                        window.location.href = '/tests/'+this.test.id+'/results';
                        return;
                    }

                    let data = response.data.data.question;
                
                    this.answers = data.answers;
                    this.question = data.question;
                    this.questionID = data.id;
                    this.questionsAnswered = response.data.data.questionsAnswered;                   

                }).finally((response) => {
                    this.showSpinner = false;
                });
        },
        submitAnswer(answer) {
            
            this.showSpinner = true;

            this.$http.post('/tests/'+this.test.id, qs.stringify({
                answer: answer,
                question: this.questionID
            })).then((response) => {
                this.getQuestion();
            }).finally((response) => {
                this.showSpinner = false;
            });
        }
    },
    computed: {
        progress: function() {
            return this.questionsAnswered / this.test.questions.length * 100;
        }
    },
    components: {
        'spinner-component': Spinner
    }
}
</script>