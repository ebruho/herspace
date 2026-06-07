import './bootstrap';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';
import { initComposer } from './composer.js';
import { initModal } from './post-modal.js';
import Alpine from 'alpinejs';
import { postCard } from './post-card.js';


window.confirmModal = function () {
    return {
        isOpen: false,
        title: '',
        message: '',
        callback: null,

        open({ title, message, callback }) {
            this.title = title;
            this.message = message;
            this.callback = callback;
            this.isOpen = true;
        },

        confirm() {
            if (this.callback) this.callback();
            this.isOpen = false;
        },
    };
};


window.postCard = postCard;


window.Alpine = Alpine;
Alpine.start();

initModal();


// Ако използва стандартен page load:
document.addEventListener('DOMContentLoaded', () => {
    initComposer();
});

window.TomSelect = TomSelect;


document.addEventListener('DOMContentLoaded', function () {
    var cityEl = document.getElementById('city_id');
    if (!cityEl) return;

    var observer = new MutationObserver(function() {
        var spinner = document.querySelector('#city-select-wrap .spinner');
        if (spinner) spinner.style.display = 'none';
    });
    observer.observe(document.getElementById('city-select-wrap'), { childList: true, subtree: true });

    new TomSelect(cityEl, {
        valueField: 'id',
        labelField: 'text',
        searchField: 'text',
        loadThrottle: 400,
        load: function (query, callback) {
            if (query.length < 2) return callback();
            fetch('/cities/search?q=' + encodeURIComponent(query))
                .then(function (r) { return r.json(); })
                .then(function (data) { callback(data); })
                .catch(function () { callback(); });
        }
    });

});