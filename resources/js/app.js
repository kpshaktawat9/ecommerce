import './bootstrap';
import {createApp} from 'vue'

import App from './App.vue'

// import Store from './store';

import router from './router';

// import { createPinia } from 'pinia';

const app = createApp(App);

// app.use(Store);

app.use(router);

// app.use(createPinia());

app.mount('#app');
