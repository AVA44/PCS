<script>
    import PrizeSearchForm from './PrizeSearchForm.vue';
    import PrizeCheckTable from './PrizeCheckTable.vue';
    import { ref } from 'vue';

    export default {
        components: {
            PrizeSearchForm, PrizeCheckTable,
        },

        data() {
            return {
                prizes: {},
            }
        },

        props: {
            opeOrder: '',
        },

        emit: [
            'GetPrizes'
        ],

        methods: {
            GetCheckedPrizeData (data) {
                this.checkedPrize = data.prize;
                this.checkedIndex = data.index;
            },
            GetCancelPrizeData (data) {
                this.cancelPrizeIndex = data.index;
                this.cancelPrizeId = data.prizeId;
            },
            GetPrizesEmit() {
                this.$refs.PrizeSearchForm.GetPrizeJsonData();
            },
        }
    }
</script>

<template>
    <PrizeSearchForm
        ref='PrizeSearchForm'
        @submitPrizeData='(val) => prizes = val'
    />

    <PrizeCheckTable
        :prizes='prizes'
        :opeOrder='opeOrder'
        @GetPrizes='GetPrizesEmit'
    />
</template>
