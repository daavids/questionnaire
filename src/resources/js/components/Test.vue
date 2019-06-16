<template>
    <spinner-component v-if="showSpinner"></spinner-component>
    <div v-else>
        <div v-if="!answers.length">
            <h4 class="mb-3">{{ question }}</h4>
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                    aria-valuemin="0" aria-valuemax="100"
                    :aria-valuenow="progress.percentage">
                    {{ progress }}% ({{ currentQuestion+1 }}/{{ totalQuestions }})
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

export default {
    props: [ 'test', 'totalQuestions' ],
    data() {
        return {
            progress: 0,
            currentQuestion: 0,
            currentAnswer: null,
            answers: [],
            question: "",
            showSpinner: true
        }
    },
    mounted() {
        this.getQuestion();
    },
    methods: {
       getQuestion() {
           this.showSpinner = true;
           this.$http.get('/tests/'+this.$props.test+'/questions')
            .then((response) => {

            }).finally((response) => {
                this.showSpinner = false;
            });
       }
    },
    components: {
        'spinner-component': Spinner
    }
}
</script>