"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var Movies = (function () {
    function Movies(templates, messageAlert, clear, dataTable, listeners, ajax) {
        var _this = this;
        this.StartScriptExecution = function () {
            this.dataTable.build('movies');
            this.listeners.handleClickOnCancelButton();
            this.listeners.handleClickOnEachCopyButton(this.ajax.getMovie, this.successGetMovie);
            this.listeners.handleClickOnCreateButton(this.ajax.postMovie, this.successPostMovie);
            this.listeners.handleClickOnDeleteButton(this.ajax.deleteMovie, this.successDeleteMovie);
            this.listeners.handleClickOnUpdateButton(this.ajax.putMovie, this.successPutMovie);
        };
        this.successGetMovie = function (response) {
            var movie = response[0];
            document.querySelector('#id_movie').value = movie.id;
            document.querySelector('#title_movie').value = movie.title;
            document.querySelector('#createdAt_movie').value = movie.created_at;
            document.querySelector('#duration_movie').value = movie.duration;
        };
        this.successPostMovie = function (response) {
            try {
                var movie = response[0];
                var message = "The movie | <em>" + movie.title + "</em> | has been created in database";
                messageAlert.display('#alertMovie', message, 'success');
                document.querySelector('#tbodyMovies').innerHTML += templates.movieRow(movie);
                _this.listeners.handleClickOnEachCopyButton(_this.ajax.getMovie, _this.successGetMovie);
                clear.clearMovieForm();
            }
            catch (e) {
                console.log(e);
                window.location = 'movies';
            }
        };
        this.successDeleteMovie = function (response) {
            try {
                var movie = response[0];
                var message = "The movie | <em>" + movie.title + "</em> | has been remove from database";
                document.querySelector("tr[data-id=\"" + movie.id + "\"]").remove();
                messageAlert.display('#alertMovie', message, 'danger');
                clear.clearMovieForm();
            }
            catch (e) {
                console.log(e);
                window.location = 'movies';
            }
        };
        this.successPutMovie = function (response) {
            try {
                var movie = response[0];
                var message = "The movie | <em>" + movie.title + "</em> | has been updated in database";
                messageAlert.display('#alertMovie', message, 'info');
                document.querySelector("tr[data-id=\"" + movie.id + "\"]").remove();
                document.querySelector('#tbodyMovies').innerHTML += templates.movieRow(movie);
                _this.listeners.handleClickOnEachCopyButton(_this.ajax.getMovie, _this.successGetMovie);
                clear.clearMovieForm();
            }
            catch (e) {
                console.log(e);
                window.location = 'movies';
            }
        };
        this.templates = templates;
        this.dataTable = dataTable;
        this.messageAlert = messageAlert;
        this.clear = clear;
        this.listeners = listeners;
        this.ajax = ajax;
        this.data = {};
        this.StartScriptExecution();
    }
    return Movies;
}());
var MoviesListeners = (function () {
    function MoviesListeners() {
        this.handleClickOnEachCopyButton = function (getMovie, success) {
            var data = {};
            var currentClickedButton = null;
            var beforeClickedButton = null;
            var selectButtons = document.getElementsByClassName("btn_select");
            for (var i = 0; i < selectButtons.length; i++) {
                selectButtons[i].addEventListener('click', function (e) {
                    return __awaiter(this, void 0, void 0, function () {
                        return __generator(this, function (_a) {
                            switch (_a.label) {
                                case 0:
                                    if (currentClickedButton !== beforeClickedButton) {
                                        beforeClickedButton = currentClickedButton;
                                    }
                                    currentClickedButton = e.target;
                                    data.id = currentClickedButton.dataset.id;
                                    currentClickedButton.classList.remove("btn-primary");
                                    currentClickedButton.classList.add("btn-info");
                                    if (beforeClickedButton !== null) {
                                        beforeClickedButton.classList.remove("btn-info");
                                        beforeClickedButton.classList.add("btn-primary");
                                    }
                                    return [4, getMovie(data, success)];
                                case 1:
                                    _a.sent();
                                    return [2];
                            }
                        });
                    });
                });
            }
        };
        this.handleClickOnCreateButton = function (postMovie, success) {
            var createButton = document.querySelector("#btn_create");
            createButton.addEventListener('click', function () {
                return __awaiter(this, void 0, void 0, function () {
                    var data;
                    return __generator(this, function (_a) {
                        switch (_a.label) {
                            case 0:
                                data = {
                                    title: document.querySelector('#title_movie').value,
                                    created_at: document.querySelector('#createdAt_movie').value,
                                    duration: document.querySelector('#duration_movie').value,
                                };
                                return [4, postMovie(data, success)];
                            case 1:
                                _a.sent();
                                return [2];
                        }
                    });
                });
            });
        };
        this.handleClickOnDeleteButton = function (deleteMovie, success) {
            var deleteButton = document.querySelector("#btn_delete");
            deleteButton.addEventListener('click', function () {
                return __awaiter(this, void 0, void 0, function () {
                    var data;
                    return __generator(this, function (_a) {
                        switch (_a.label) {
                            case 0:
                                data = {
                                    id: document.querySelector('#id_movie').value,
                                };
                                return [4, deleteMovie(data, success)];
                            case 1:
                                _a.sent();
                                return [2];
                        }
                    });
                });
            });
        };
        this.handleClickOnCancelButton = function () {
            var cancelButton = document.querySelector("#btn_cancel");
            cancelButton.addEventListener('click', function (e) {
                clear.clearMovieForm();
            });
        };
        this.handleClickOnUpdateButton = function (putMovie, success) {
            var updateButton = document.querySelector("#btn_update");
            updateButton.addEventListener('click', function () {
                return __awaiter(this, void 0, void 0, function () {
                    var data;
                    return __generator(this, function (_a) {
                        switch (_a.label) {
                            case 0:
                                data = {
                                    id: document.querySelector('#id_movie').value,
                                    title: document.querySelector('#title_movie').value,
                                    created_at: document.querySelector('#createdAt_movie').value,
                                    duration: document.querySelector('#duration_movie').value,
                                };
                                return [4, putMovie(data, success)];
                            case 1:
                                _a.sent();
                                return [2];
                        }
                    });
                });
            });
        };
    }
    return MoviesListeners;
}());
var MoviesAjax = (function () {
    function MoviesAjax() {
        this.getMovie = function (data, success) {
            var dataToSend = {
                method: 'GET',
                route: "movies",
                JSON: true,
                id: data.id
            };
            $.ajax({
                type: "POST",
                url: "movies",
                async: true,
                data: dataToSend,
                dataType: "json",
                cache: false,
            })
                .done(function (response) {
                success(response);
            })
                .fail(function (error) {
                console.log('error : ' + error.status);
            });
        };
        this.postMovie = function (data, success) {
            var dataToSend = {
                method: 'POST',
                route: "movies",
                JSON: true,
                title: data.title,
                created_at: data.created_at,
                duration: data.duration
            };
            $.ajax({
                type: "POST",
                url: "movies",
                async: true,
                data: dataToSend,
                dataType: "json",
                cache: false,
            })
                .done(function (response) {
                success(response);
            })
                .fail(function (error) {
                console.log('error : ' + error.status);
            });
        };
        this.putMovie = function (data, success) {
            var dataToSend = {
                method: 'PUT',
                route: "movies",
                JSON: true,
                id: data.id,
                title: data.title,
                created_at: data.created_at,
                duration: data.duration
            };
            $.ajax({
                type: "POST",
                url: "movies",
                async: true,
                data: dataToSend,
                dataType: "json",
                cache: false,
            })
                .done(function (response) {
                success(response);
            })
                .fail(function (error) {
                console.log('error : ' + error.status);
            });
        };
        this.deleteMovie = function (data, success) {
            var dataToSend = {
                method: 'DELETE',
                route: "movies",
                JSON: true,
                id: data.id,
            };
            $.ajax({
                type: "POST",
                url: "movies",
                async: true,
                data: dataToSend,
                dataType: "json",
                cache: false,
            })
                .done(function (response) {
                success(response);
            })
                .fail(function (error) {
                console.log('error : ' + error.status);
            });
        };
    }
    return MoviesAjax;
}());
(function (templates, messageAlert, clear, dataTable) {
    var listeners = new MoviesListeners();
    var ajax = new MoviesAjax();
    new Movies(templates, messageAlert, clear, dataTable, listeners, ajax);
})(templates, messageAlert, clear, dataTable);
