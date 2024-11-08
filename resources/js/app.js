/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

// Import jQuery
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// Import Bootstrap
import 'bootstrap';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');

document.addEventListener('DOMContentLoaded', function() {
    var entrepriseForm = document.getElementById('entrepriseForm');
    if (entrepriseForm) {
        entrepriseForm.addEventListener('submit', function(event) {
            document.getElementById('loadingIndicatorEntreprise').style.display = 'flex';
            document.querySelector('#entrepriseForm button[type="submit"]').disabled = true;
        });
    }

    var demandeForm = document.getElementById('demandeForm');
    if (demandeForm) {
        demandeForm.addEventListener('submit', function(event) {
            document.getElementById('loadingIndicator').style.display = 'flex';
            document.querySelector('#demandeForm button[type="submit"]').disabled = true;
        });
    }

    var questionnaireForm = document.getElementById('questionnaireForm');
    if (questionnaireForm) {
        questionnaireForm.addEventListener('submit', function(event) {
            document.getElementById('loadingIndicatorQuestionnaire').style.display = 'flex';
            document.querySelector('#questionnaireForm button[type="submit"]').disabled = true;
        });
    }

    var reponseForm = document.getElementById('reponseForm');
    if (reponseForm) {
        reponseForm.addEventListener('submit', function(event) {
            document.getElementById('loadingIndicatorReponse').style.display = 'flex';
            document.querySelector('#reponseForm button[type="submit"]').disabled = true;
        });
    }

    document.getElementById('toggleViewBtn').addEventListener('click', function () {
        var container = document.getElementById('entrepriseContainer');
        container.classList.toggle('list-view');
        container.classList.toggle('grid-view');
    });




});



document.addEventListener("DOMContentLoaded", function () {
    $('#liste_demande').DataTable({
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Tout"]],
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        language: {
            processing: "Traitement en cours...",
            search: "Rechercher&nbsp;:",
            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            info: "De _START_ &agrave; _END_ sur _TOTAL_",
            infoEmpty: "De 0 &agrave; 0 sur 0",
            infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable: "Aucune donnée disponible dans le tableau",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });

});
