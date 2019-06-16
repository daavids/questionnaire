<template>
    <div v-if="tests.length">
        <h4>Choose your test</h4>
    </div>
    <div v-else>
        <h4>No tests are currently available.</h4>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tests: []
        }
    },
    methods: {
    }
}
</script>