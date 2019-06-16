<template>
    <form action="/login" method="POST" class="py-5">
        <div class="form-group">
            <label for="name">Enter your name to begin</label>
            <input type="text" name="name" id="name" class="form-control"
                required placeholder="Enter your name" v-model="name">
        </div>
        <input type="hidden" name="_token" v-model="token">
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            token: ""
        }
    },
    mounted() {
        this.token = document.querySelector('meta[name="csrf_token"]').getAttribute('content');
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
