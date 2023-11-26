import './bootstrap';

import {createApp} from 'vue';

import PrizeIndex from './PrizeIndex.vue';
import PrizeCheck from './PrizeCheck.vue';
import PrizeCreate from './PrizeCreate.vue';
import PrizeDetailTable from './PrizeDetailTable.vue';

createApp(PrizeIndex).mount('#prizeIndex');
// createApp(PrizeDetailTable).mount('#prizeDetailTable');

createApp({}).component('PrizeDetailTable', PrizeDetailTable).mount('#prizeDetailTable');
