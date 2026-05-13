import Chart from 'chart.js/auto';

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

$(document).ready(() => {
    document.querySelectorAll('.player-chart').forEach((canvas) => {
        const dataset = JSON.parse(canvas.dataset.values);

        let y_options = {
            beginAtZero: true,
            ticks: {
                callback: function (value) {
                    return `${value}${canvas.dataset.unit}`;
                }
            }
        };

        if (typeof canvas.dataset.max !== 'undefined') {
           y_options = {
               ...y_options,
               ...{
                    max: canvas.dataset.max,
               }
           }
        }

        new Chart(canvas, {
            type: canvas.dataset.type,
            data: {
                labels: dataset.labels,
                datasets: [{
                    label: canvas.dataset.title,
                    data: dataset.values
                }],
            },
            options: {
                scales: {
                    y: y_options
                }
            }
        });
    });
});
