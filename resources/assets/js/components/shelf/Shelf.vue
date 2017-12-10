<template>
    <div class="shelf">
        <h3>Shelf</h3>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                username: ''
            }
        },
        mounted() {
            this.username = this.$route.params.username;
        }
    }
</script>