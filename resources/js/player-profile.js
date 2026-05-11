import { spinner } from "./app.js";

const getHistory = game_date => {
    $('#player-games-wrapper').html(spinner());
    const split_pathname = window.location.pathname.split('/');
    const player_id = split_pathname[split_pathname.length - 1];

    $.get(`/player/${player_id}/history/${game_date}`, response => {
        $('#player-games-wrapper').html(response);
    });
};

$(function () {
    getHistory($('#player-history-date').val());

    $('#player-history-date').change(e => {
        getHistory($('#player-history-date').val());
    });
});
