import './bootstrap';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

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