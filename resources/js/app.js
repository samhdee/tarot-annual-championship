import $ from 'jquery';
import '@fortawesome/fontawesome-free/js/all.min.js';
import 'bootstrap/dist/js/bootstrap.min.js';
import select2 from 'select2';

import.meta.glob([
  '../fonts/**',
]);

window.jQuery = window.$ = $;

export const spinner = () => {
    return '<div class="d-flex justify-content-center">' +
        '<div class="mt-5 spinner-border text-light" role="status">' +
            '<span class="visually-hidden">Loading...</span>' +
        '</div>' +
    '</div>';
}

$(function () {
    if ($('.select2').length > 0) {
        select2();
        $('.select2').select2();
    }

    // Ajoute le nom de domaine et le token CSRF à chaque appel AJAX
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

    // Déclenche l'appel AJAX vers data-ajax_url et rafraîchit data-view_container
    $(document).on('click', '.btn-action', e => {
        e.preventDefault();
        const button = $(e.currentTarget);

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
