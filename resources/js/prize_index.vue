<script>
    import Prize_search_form from './prize_search_form.vue';
    import Prize_index_table from './prize_index_table.vue';

    export default {
        components: {
            Prize_search_form, Prize_index_table,
        },
        
        data() {
            return {
                prizes: {},
            }
        },
    }
</script>

<template>
    <Prize_search_form @submitPrizeData='(val) => prizes = val' />
    <Prize_index_table :prizes='prizes'/>
</template>
