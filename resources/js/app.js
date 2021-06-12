/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('opportunity-component', require('./components/OpportunityComponent.vue').default);

Vue.component('opportunity-map-component', require('./components/OpportunityMapComponent.vue').default);

Vue.component('recording-component', require('./components/RecordingComponent.vue').default);

Vue.component('record-video-component', require('./components/RecordVideoComponent.vue').default);

Vue.component('fusion-chart-component', require('./components/FusionChartComponent.vue').default);

Vue.component('drop-zone-component', require('./components/DropZoneComponent.vue').default);

Vue.component('calendar-component', require('./components/CalendarComponent.vue').default);

Vue.component('order-component', require('./components/OrderComponent.vue').default);

Vue.component('seguimiento-order-component', require('./components/OrderListComponent.vue').default);

Vue.component('dealer-component', require('./components/DealerComponent.vue').default);

Vue.component('encuesta-component', require('./components/EncuestaComponent.vue').default);

Vue.component('opportunity-list-component', require('./components/OpportunityListComponent.vue').default);

Vue.component('prospecto-list-component', require('./components/ProspectoListComponent.vue').default);

Vue.component('encuesta-prospecto-component', require('./components/EncuestaProspectoComponent.vue').default);

Vue.component('subir-csv-component', require('./components/SubirCSVComponent.vue').default);

Vue.component('gestor-ruta-component', require('./components/GestorRutaComponent.vue').default);

Vue.component('gestor-prospecto-component', require('./components/ProspectoGestorComponent.vue').default);

Vue.component('seguimiento-ruta-component', require('./components/SeguimientoRutaComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
