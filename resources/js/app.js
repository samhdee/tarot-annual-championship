import $ from 'jquery';
import '@fortawesome/fontawesome-free/js/all.min.js';
import 'bootstrap/dist/js/bootstrap.min.js';

import.meta.glob([
  // '../images/**',
  '../fonts/**',
]);

window.jQuery = window.$ = $;

$(function () {
    $.ajaxSetup({
        beforeSend: (xhr, options) => {
            if (!options.url.startsWith(window.location.origin)) {
                options.url = window.location.origin + options.url;
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });

    $(document).on('click', '.btn-action', e => {
        e.preventDefault();
        const button = $(e.currentTarget);
        console.log($(button));

        $.get($(button).data('ajax_url')).then(response => {
            if (
                $(button).data('view_container')
                && $($(button).data('view_container')).length > 0
                && response.view.length > 0
            ) {
                $($(button).data('view_container')).html(response.view)
            }
        });
    });
})
