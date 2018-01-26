import Vue from "vue";

export default class {
    constructor() {
        this.vue = new Vue();
    }

    fire(event, data = null) {
        this.vue.$emit(event, data);
    }

    listen(event, callback) {
        this.vue.$on(event, callback);
    }

    off(event, callback) {
        this.vue.$off(event, callback);
    }
};