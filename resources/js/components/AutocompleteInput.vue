<template>
    <div class="form-group">
        <label :for="id">{{ label }}</label>
        <input type="text" :name="name" :id="id" class="form-control"
               :class="{'is-invalid' : error}"
               v-model="query"
               :required="required"
               @keydown.up="keyUp"
               @keydown.down="keyDown"
               @keydown.enter="selectItem"
               @keydown.delete="resetSelectedItem"
               @input="showOptions"
               @focusout="hideOptions(100)"
               autocomplete="off">

        <div class="options-wrapper" v-show="optionsVisible && matches.length > 0">
            <ul class="options-list" ref="optionsList">
                <li v-for="(match, index) in matches" :key="index"
                    :class="{'selected' : (selected === index)}"
                    v-text="match.name"
                    @click="selectItem"
                    @mouseover="itemHover(index)">
                </li>
            </ul>
        </div>

        <span class="invalid-feedback" role="alert" v-if="error">
                <strong>{{ error }}</strong>
        </span>
    </div>
</template>

<script>
export default {
    props: [
        'items', 'error', 'name', 'id', 'label', 'required', 'old'
    ],

    mounted() {
        if (this.old) {
            this.query = this.old
        }
    },

    data() {
        return {
            query: '',
            selected: 0,
            optionsVisible: false,
            itemHeight: 36
        }
    },

    methods: {
        showOptions() {
            this.optionsVisible = true
        },

        hideOptions(timeout) {
            setTimeout(() => {
                this.optionsVisible = false
            }, timeout)
        },

        itemHover(index) {
            this.selected = index
        },

        resetSelectedItem() {
            this.selected = 0
        },

        selectItem() {
            this.query = this.matches[this.selected].name
            this.hideOptions(0)
            this.resetSelectedItem()
        },

        keyUp() {
            if (this.selected !== 0) {
                this.selected -= 1
                this.scrollToItem()
            }
        },

        keyDown() {
            if (this.selected < this.matches.length - 1) {
                this.selected += 1
                this.scrollToItem()
            }
        },

        scrollToItem() {
            this.$refs.optionsList.scrollTop = this.selected * this.itemHeight;
        }
    },

    computed: {
        matches() {
            if (this.query === '') {
                return [];
            }

            return this.items.filter(item => item.name.toLowerCase().startsWith(this.query.toLowerCase()))
        }
    }
}
</script>

<style>
.options-wrapper {
    position: relative;
}

.options-list {
    position: absolute;
    top: 3px;
    border: 1px solid rgba(0, 0, 0, 0.15);
    background-color: #fff;
    width: 100%;
    padding: 0;
    margin: 0;
    list-style: none;
    max-height: 180px;
    overflow-y: auto;
}

.options-list li {
    display: block;
    cursor: pointer;
    padding: .4rem .7rem;
}

.options-list li.selected {
    background-color: #efefef;
}
</style>