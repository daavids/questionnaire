<template>
    <form action="/login" method="POST" @submit="attemptAuth">
        <div class="form-group">
            <label for="name">Enter your name to begin</label>
            <input type="text" name="name" id="name" class="form-control"
                required placeholder="Enter your name" v-model="name">
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            name: "",
        }
    },
    methods: {
        attemptAuth() {
            this.$http.post('/login', {
                name: this.name,
                token: document.querySelector('meta[name=csrf_token]').getAttribute('content')
            });
        }
    }
}
</script>

<style scoped>
form {
    max-width: 500px !important;
    margin-right: auto;
    margin-left: auto;
}
</style>
