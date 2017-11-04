<template>
    <div>
        <div class="header">
            <slot name="header">
                <h4 class="title">{{title}}</h4>
                <p class="category">{{subTitle}}</p>
            </slot>
        </div>
        <div class="content table-responsive table-full-width">
            <table class="table" :class="tableClass">
                <thead>
                    <th v-for="(column, key) in columns" v-bind:key="key">
                        {{column}}
                    </th>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in data" v-bind:key="key">
                        <td v-for="(column, key) in columns" v-if="hasValue(item, column)" v-bind:key="key">
                            <div v-if="hasValue(item, column) && !isAction(item, column)">
                                {{itemValue(item, column)}}
                            </div>
                            <div v-if="isAction(item, column)">
                                <div class="actions" v-for="(action, key) in item.actions" v-bind:key="key">
                                    <a :class="action.classes" v-html="action.text" @click.prevent="action.click"></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            columns: Array,
            data: Array,
            type: {
                type: String, // striped | hover
                default: 'Striped'
            },
            title: {
                type: String,
                default: ''
            },
            subTitle: {
                type: String,
                default: ''
            },
            useActions: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            tableClass() {
                return `table-${this.type}`;
            }
        },
        methods: {
            hasValue(item, column) {
                return this.itemValue(item, column) !== 'undefined';
            },
            isAction(item, column) {
                return this.useActions && Array.isArray(this.itemValue(item, column));
            },
            itemValue(item, column) {
                return item[column.toLowerCase()];
            }
        }
    }
</script>

<style scoped lang="scss">
    .table-responsive {
        overflow-x: scroll;
    }
    
    .actions {
        display: inline-block;
        >a {
            cursor: pointer;
        }
    }
</style>
