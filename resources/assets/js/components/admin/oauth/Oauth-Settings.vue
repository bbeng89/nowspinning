<template>
    <div id="oauth-settings">
        <personal-access-tokens></personal-access-tokens>
    </div>
</template>

<script>
    import PersonalAccessTokens from './passport/PersonalAccessTokens.vue';

    export default {
        components: {
            PersonalAccessTokens
        }
    }
</script>