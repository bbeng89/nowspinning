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
                    <hr/>
                    <button class="btn btn-default"><i class="fa fa-plus-circle"></i> On Deck</button>
                    <button class="btn btn-primary"><i class="fa fa-thumbs-o-up"></i> Spin Now</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['thumbnail', 'artists', 'title'],
        computed: {
            artistDisplay() {
                return this.artists.map(a => a.name).join(', ');
            }
        }
    }
</script>