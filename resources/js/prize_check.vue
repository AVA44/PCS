<script>
    import Prize_search_form from './prize_search_form.vue';
    import Prize_check_table from './prize_check_table.vue';

    export default {
        components: {
            Prize_search_form, Prize_check_table
        },

        data() {
            return {
                prizes: {},
            }
        },

        methods: {
            GetCheckedPrizeData (data) {
                this.checkedPrize = data.prize;
                this.checkedIndex = data.index;
            },
            GetCancelPrizeData (data) {
                this.cancelPrizeIndex = data.index;
                this.cancelPrizeId = data.prizeId;
            }
        }
    }
</script>

<template>
    <Prize_search_form
        @submitPrizeData='(val) => prizes = val'
    />

    <Prize_check_table
        :prizes='prizes'
    />
</template>
