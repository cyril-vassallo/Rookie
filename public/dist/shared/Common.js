"use strict";
var MessageAlert = (function () {
    function MessageAlert() {
        this.display = function (where, message, alertLevel) {
            var template = "<div class=\"alert alert-" + alertLevel + " alert-dismissible fade show\" role=\"alert\">\n                " + message + "\n                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n                <span aria-hidden=\"true\">&times;</span>\n                </button>\n            </div>";
            document.querySelector(where).innerHTML = template;
        };
    }
    return MessageAlert;
}());
var Templates = (function () {
    function Templates() {
        this.movieRow = function (movie) {
            var timeZone = 'Europe/Kaliningrad';
            var timeZoneOffset = '+02:00';
            return "         \n            <tr data-id='" + movie.id + "'>\n                <td hidden>" + movie.id + "</td>\n                <td>" + movie.title + "</td>\n                <td>" + movie.created_at.toLocaleString('fr-FR', { format: 'd/m/y' }) + "</td>\n                <td>" + movie.duration + "</td>\n                <td>\n                    <button type=\"button\" data-id=\"" + movie.id + "\" class=\"btn btn-primary copyButton\">\n                        Select\n                    </button>\n                </td>\n            </tr>";
        };
        this.actorRow = function (actor) {
        };
    }
    return Templates;
}());
var Clear = (function () {
    function Clear() {
        this.clearMovieForm = function () {
            document.querySelector('#id_movie').value = '';
            document.querySelector('#title_movie').value = '';
            document.querySelector('#createdAt_movie').value = '';
            document.querySelector('#duration_movie').value = '';
        };
        this.clearActorForm = function () {
        };
    }
    return Clear;
}());
var templates = new Templates();
var messageAlert = new MessageAlert();
var clear = new Clear();
