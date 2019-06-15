<template>
    <form action="/login" method="POST">
        <div class="form-group">
            <label for="name">Enter your name to begin</label>
            <input type="text" name="name" id="name" class="form-control" required placeholder="Enter your name">
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
    }
}
</script>