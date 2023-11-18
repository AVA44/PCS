import './bootstrap';

import {createApp} from 'vue';

import Prize_index from './prize_index.vue';
import Prize_check from './prize_check.vue';
import Prize_create from './prize_create.vue';

// createApp(Prize_index).mount('#prize_index');
createApp(Prize_create).mount('#prizeIndex');
