import './bootstrap';
import { createApp } from 'vue';

import LeadComponent from "./components/LeadComponent.vue";

const app = createApp({});

app.component('lead-component', LeadComponent);

app.mount('#app');
