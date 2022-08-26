import './bootstrap';
import { createApp } from 'vue';
import Main from "./components/Main";
import Questions from "./components/Questions";
import CreateQuestion from "./components/CreateQuestion";
import NavButton from "./components/buttons/NavButton.vue";
import Notifications from '@kyvg/vue3-notification';

const app = createApp({});

app.component('main-menu', Main);
app.component('questions', Questions);
app.component('create-question', CreateQuestion);
app.component('nav-button', NavButton);
app.use(Notifications);

app.mount('#app');
