<template>
    <div class="thumbnail">
        <img :src="image.src">
        <div class="caption">
            <button type="button" class="btn btn-danger btn-sm btn-block">Delete</button>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['image']
    }
</script>