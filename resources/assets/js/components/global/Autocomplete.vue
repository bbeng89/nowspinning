<template>
    <div class="form-group autocomplete">
        <input v-model="query" type="text" class="form-control" :placeholder="placeholder">
        <ul v-if="results.length > 0" class="list-group autocomplete-results">
            <a v-for="result in results" class="list-group-item"
               href="javascript:void(0)"
               @click="resultClicked(result)">{{ result.text }}</a>
        </ul>
    </div>
</template>
<script>
    export default {
        props: ['placeholder', 'minCharacters', 'items'],
        data() {
            return {
                query: '',
                results: this.items
            }
        },
        watch: {
            query(newQuery, oldQuery) {
                if(newQuery.length >= parseInt(this.minCharacters)) {
                    this.$emit('search', newQuery);
                }
                else {
                    this.clearResults();
                }
            }
        },
        methods: {
            resultClicked(result) {
                this.$emit('result-clicked', result)
            },
            resolved() {
                this.clearResults();
                this.query = '';
            },
            clearResults() {
                this.results.splice(0, this.results.length);
            }
        }
    }
</script>