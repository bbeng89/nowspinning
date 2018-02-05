<template>
    <div class="thumbnail">
        <img :src="image.src">
        <div class="caption">
            <button @click="deleteImage" type="button" class="btn btn-danger btn-sm btn-block">Delete</button>
        </div>
    </div>
</template>
<script>
    import users from '../../api/users';

    export default {
        props: ['image'],
        methods: {
            deleteImage() {
                if(confirm('Are you sure you want to delete this image?')) {
                    users.removeImage(this.image.id, response => {
                        this.$emit('profile-image-deleted', this.image);
                    });
                }
            }
        }
    }
</script>