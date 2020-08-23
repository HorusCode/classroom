<template>
    <div class="s-control s-with-icon-left">
        <span class="s-icon s-left">
            <i class="mdi mdi-search-web"></i>
        </span>
        <input
            class="s-input"
            type="text"
            v-model="newValue"
            v-bind="$attrs"
            @input="onInput"
            @blur="isActive = isActiveSuggestion"
            @keydown.enter="onEnter"
            @keydown.down="onDown"
            @keydown.up="onUp"
        />
        <div v-if="isActive" :class="{'s-active': isActive}" class="s-dropdown">


            <ul class="s-dropdown__content">
                <li v-show="loading" class="s-dropdown__item s-disabled">
                    <slot name="loading">
                        <span class="s-loader"></span>
                    </slot>
                </li>
                <li v-show="isEmpty && !loading" class="s-dropdown__item s-disabled">
                    Ничего не найдено
                </li>
                <li
                    v-for="(suggestion, index) in matches"
                    :key="index"
                    class="s-dropdown__item"
                    :class="{ 's-active': isActiveElement(index) }"
                    @click="suggestionSelect(suggestion)"
                >
                    {{ suggestion[field] }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Autocomplete",
        props: {
            data: {
                type: Array,
                default: () => []
            },
            loading: {
                type: Boolean,
                default: false,
            },
            field: {
              type: String,
              default: 'value'
            },
            customFilter: Function,
            value: [Number, String]
        },
        data() {
            return {
                isActive: false,
                current: 0,
                newValue: this.value,
                selected: null,
            };
        },
        computed: {
            // Filtering the suggestion based on the input
            matches() {
                if (typeof this.customFilter !== 'undefined') {
                    return this.customFilter();
                }
                return this.data.filter(obj => {
                    return obj[this.field].toLowerCase().indexOf(this.newValue.toLowerCase()) >= 0;
                });
            },

            isActiveSuggestion() {
                return this.matches.length !== 0 && this.isActive === true;
            },

            isEmpty() {
                return this.matches.length === 0;
            },
        },
        mounted() {
            document.addEventListener("click", this.handleClickOutside);
        },
        destroyed() {
            document.removeEventListener("click", this.handleClickOutside);
        },
        methods: {

            onInput(event) {
                this.newValue = event.target.value;
                if (!this.isActive) {
                    this.isActive = true;
                    this.current = 0;
                }
                this.$emit("input", this.newValue);
            },
            // When enter pressed on the input
            onEnter() {
                this.suggestionSelect(this.matches[this.current])
            },
            // When up pressed while suggestions are isActive
            onUp() {
                if (this.current > 0) {
                    this.current--;
                }
            },
            // When up pressed while suggestions are isActive
            onDown() {
                if (this.current < this.matches.length - 1) {
                    this.current++;
                }
            },
            handleClickOutside(evt) {
                if (!this.$el.contains(evt.target)) {
                    this.isActive = false;
                    this.counter = 0;
                }
            },
            // For highlighting element
            isActiveElement(index) {
                return index === this.current;
            },
            // When one of the suggestion is clicked
            suggestionSelect(suggestion) {
                this.selected = suggestion;
                this.newValue = suggestion[this.field];
                this.$emit("select", suggestion);
                this.isActive = false;
            },
        },
    };
</script>

<style scoped></style>
