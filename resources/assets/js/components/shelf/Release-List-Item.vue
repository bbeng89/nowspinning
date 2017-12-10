<template>
    <div class="panel release-list-item">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <img class="img-responsive" :src="thumbnail">
                </div>
                <div class="col-sm-8">
                    <strong>{{ title }}</strong> <br/>
                    {{ artistDisplay }}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['thumbnail', 'artistDisplay', 'title'],
    }
</script>