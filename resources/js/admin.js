$(function () {
    $(document).on('click', '.btn-action', e => {
        const button = $(e.target);
        console.log($(button));

        $.get($(button).data('url'));
    });
});
