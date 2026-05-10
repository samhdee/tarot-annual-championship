import { spinner } from "./app.js";

const getHistory = game_date => {
    $('#player-games-wrapper').html(spinner());

    $.get(`/player/history/${game_date}`, response => {
        $('#player-games-wrapper').html(response);
    });
};

$(function () {
    getHistory($('#player-history-date').val());
    console.log($('#player-history-date').val());

    $('#player-history-date').change(e => {
        getHistory($('#player-history-date').val());
    });
});
