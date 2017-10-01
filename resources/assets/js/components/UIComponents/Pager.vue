<template>
    <div class="pager">
        <button class="btn" :class="{disabled: initialPageReached}" :disabled="initialPageReached"
                @click.prevent="goBackward()">
            Previous
        </button>
        {{currentPage}}
        <span> of </span>
        {{totalPages}}
        <button class="btn" :class="{disabled: totalPagesReached}" :disabled="totalPagesReached"
                @click.prevent="goForward()">
            Next
        </button>
    </div>
</template>
<script>
    export default {
        props: {
            itemsPerPage: {type: Number, default: 5},
            items: Array
        },
        computed: {
            totalPages() {
                if (this.$props.items && this.$props.items.length) {
                    return Math.ceil(this.$props.items.length / this.$props.itemsPerPage);
                }

                return 1;
            },
            totalPagesReached() {
                return this.currentPage === this.totalPages;
            },
            initialPageReached() {
                return this.currentPage === 1;
            },
            itemsCopy() {
                return this.$props.items.slice(0);
            }
        },
        data() {
            return {
                currentPage: 1,
                totalItemsDisplayed: this.calculateItemsDisplayed()
            };
        },
        watch: {
            itemsCopy() {
                this.currentPage = 1;
                this.totalItemsDisplayed = this.calculateItemsDisplayed();
            }
        },
        methods: {
            calculateItemsDisplayed() {
                return this.$props.items.length > this.itemsPerPage ? this.itemsPerPage : this.$props.items.length;
            },
            goBackward() {
                if (!this.initialPageReached) {
                    this.currentPage--;
                    const itemsToEmit = this.$props.items.slice(
                        this.totalItemsDisplayed - (this.$props.itemsPerPage * 2),
                        this.totalItemsDisplayed - this.$props.itemsPerPage
                    );
                    this.totalItemsDisplayed -= this.$props.itemsPerPage;
                    this.refreshItems(itemsToEmit);
                }
            },
            goForward() {
                if (!this.totalPagesReached) {
                    this.currentPage++;
                    const itemsToEmit = this.$props.items.slice(
                        this.totalItemsDisplayed,
                        this.$props.itemsPerPage + this.totalItemsDisplayed
                    );
                    this.totalItemsDisplayed += this.$props.itemsPerPage;
                    this.refreshItems(itemsToEmit);
                }
            },
            refreshItems(items) {
                this.$emit('pager-update', items);
            }
        }
    };
</script>
<style scoped lang="scss">
    .btn {
        &.disabled:hover {
            color: initial !important;
        }
    }
</style>