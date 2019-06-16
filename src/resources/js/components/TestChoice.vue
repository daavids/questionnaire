<template>
    <spinner-component v-if="showSpinner"></spinner-component>
    <div v-else>
        <div v-if="tests.length">
            <h4>Choose your test</h4>
            <a :href="'/tests/'+test.id" class="btn btn-primary btn-lg m-3"
                v-for="test in tests" :key="test.id">{{ test.name }}</a>
        </div>
        <div v-else>
            <h4>No tests are currently available.</h4>
        </div>
    </div>
</template>

<script>

import Spinner from './Spinner.vue';

export default {
    data() {
        return {
            tests: [],
            showSpinner: true
        }
    },
    mounted() {
        this.getTests();
    },
    methods: {
        getTests() {
            this.$http.get('/tests')
                .then((response) => {
                    this.tests = response.data.data;
                }).catch((response) => {
                    //
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