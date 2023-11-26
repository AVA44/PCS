<script>
    import PrizeSearchForm from './PrizeSearchForm.vue';
    import PrizeCheckTable from './PrizeCheckTable.vue';

    export default {
        components: {
            PrizeSearchForm, PrizeCheckTable,
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
    <PrizeSearchForm
        @submitPrizeData='(val) => prizes = val'
    />

    <PrizeCheckTable
        :prizes='prizes'
    />
</template>
