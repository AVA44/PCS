<script>
    import PrizeSearchForm from './PrizeSearchForm.vue';
    import PrizeIndexTable from './PrizeIndexTable.vue';

    export default {
        components: {
            PrizeSearchForm, PrizeIndexTable,
        },

        data() {
            return {
                prizes: {},
            }
        },
    }
</script>

<template>
    <PrizeSearchForm @submitPrizeData='(val) => prizes = val' />
    <PrizeIndexTable :prizes='prizes'/>
</template>
