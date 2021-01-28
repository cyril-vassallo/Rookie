/**
 * ----------------------------------
 *              MOVIES
 * ----------------------------------
 * @author Cyril VASSALLO
 * In this file you will find:
 * - stored classes for movies page
 * - instances of object in the Immediately-invoked Function of movies page
 * /

/**
 * @Class 
 * General class for the movies page
 */
class Movies {
    constructor(templates, messageAlert, clear, listeners, ajax) {
        this.templates = templates;
        this.messageAlert = messageAlert;
        this.clear = clear;
        this.listeners = listeners;
        this.ajax = ajax;
        this.data = {};
        this.StartScriptExecution()
    }

    /**
     * Add initial events 
     */
    StartScriptExecution = function () {
        this.listeners.handleClickOnCancelButton();
        this.listeners.handleClickOnEachCopyButton(this.ajax.getMovie, this.successGetMovie);
        this.listeners.handleClickOnCreateButton(this.ajax.postMovie, this.successPostMovie);
        this.listeners.handleClickOnDeleteButton(this.ajax.deleteMovie, this.successDeleteMovie);
        this.listeners.handleClickOnUpdateButton(this.ajax.putMovie, this.successPutMovie);
    }

    /**
     * Callback after get a movie
     * @param {array} response 
     */
    successGetMovie = function (response) {
        let movie = response[0];
        document.querySelector('#id_movie').value = movie.id;
        document.querySelector('#title_movie').value = movie.title;
        document.querySelector('#createdAt_movie').value = movie.created_at;
        document.querySelector('#duration_movie').value = movie.duration;
    }

    /**
     * Callback after get Post a movie
     * @param {array} response 
     */
    successPostMovie = (response) => {
        try {
            let movie = response[0];
            let message = `The movie | <em>${movie.title}</em> | has been created in database`;
            messageAlert.display('#alertMovie', message, 'success');
            document.querySelector('#tbodyMovies').innerHTML += templates.movieRow(movie);
            this.listeners.handleClickOnEachCopyButton(this.ajax.getMovie, this.successGetMovie);
        } catch (e) {
            console.log(e);
        }

    }

    /**
     * Callback after Delete a movie
     * @param {array} response 
     */
    successDeleteMovie = function (response) {
        try {
            let movie = response[0];
            let message = `The movie | <em>${movie.title}</em> | has been remove from database`;
            document.querySelector(`tr[data-id="${movie.id}"]`).remove();
            messageAlert.display('#alertMovie', message, 'danger')
            clear.clearMovieForm();
        } catch (e) {
            console.log(e);
        }
    }

    /**
     * Callback after Update a movie
     * @param {array} response 
     */
    successPutMovie = (response) => {
        try {
            let movie = response[0];
            let message = `The movie | <em>${movie.title}</em> | has been updated in database`;
            messageAlert.display('#alertMovie', message, 'info');
            document.querySelector(`tr[data-id="${movie.id}"]`).remove();
            document.querySelector('#tbodyMovies').innerHTML += templates.movieRow(movie);
            this.listeners.handleClickOnEachCopyButton(this.ajax.getMovie, this.successGetMovie);
        } catch (e) {
            console.log(e);
        }
    }
}

/**
 * @Class 
 * Add event to DOM elements for movies page
 */
class MoviesListeners {
    constructor() { }

    /**
     * On click event Handler on select buttons
     * @param {function} getMovie 
     * @param {function} success 
     */
    handleClickOnEachCopyButton = function (getMovie, success) {
        let data = {};
        let selectButtons = document.getElementsByClassName("btn_select");
        for (let i = 0; i < selectButtons.length; i++) {
            selectButtons[i].addEventListener('click', function (e) {
                data.id = e.target.dataset.id;
                getMovie(data, success)
            });
        }
    }

    /**
     * On click event Handler on create button
     * @param {function} getMovie 
     * @param {function} success 
     */
    handleClickOnCreateButton = function (postMovie, success) {
        let createButton = document.querySelector("#btn_create");
        createButton.addEventListener('click', function () {
            let data = {
                title: document.querySelector('#title_movie').value,
                created_at: document.querySelector('#createdAt_movie').value,
                duration: document.querySelector('#duration_movie').value,
            };
            postMovie(data, success)
        });
    }

    /**
     * On click event Handler on delete button
     * @param {function} getMovie 
     * @param {function} success 
     */
    handleClickOnDeleteButton = function (deleteMovie, success) {
        let deleteButton = document.querySelector("#btn_delete");
        deleteButton.addEventListener('click', function () {
            let data = {
                id: document.querySelector('#id_movie').value,
            };
            deleteMovie(data, success)
        });
    }

    /**
     * On click event Handler on cancel button
     */
    handleClickOnCancelButton = function () {
        let cancelButton = document.querySelector("#btn_cancel");
        cancelButton.addEventListener('click', function () {
            clear.clearMovieForm();
        });
    }

    /**
     * On click event Handler on update button
     * @param {function} getMovie 
     * @param {function} success 
     */
    handleClickOnUpdateButton = function (putMovie, success) {
        let updateButton = document.querySelector("#btn_update");
        updateButton.addEventListener('click', function () {
            let data = {
                id: document.querySelector('#id_movie').value,
                title: document.querySelector('#title_movie').value,
                created_at: document.querySelector('#createdAt_movie').value,
                duration: document.querySelector('#duration_movie').value,
            };
            putMovie(data, success)
        });
    }
}

/**
 * @Class 
 * Ajax methods for movies page
 */
class MoviesAjax {
    constructor() { }

    /**
     * Emit request to get one movie
     * @param {object} data 
     * @param {function} success 
     */
    getMovie = function (data, success) {
        let dataToSend = {
            method: 'GET',
            route: "movies",
            bJSON: true,
            id: data.id
        }
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
    }


    /**
     * Emit request to create one movie
     * @param {object} data 
     * @param {function} success 
     */
    postMovie = function (data, success) {
        let dataToSend = {
            method: 'POST',
            route: "movies",
            bJSON: true,
            title: data.title,
            created_at: data.created_at,
            duration: data.duration
        }
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
    }

    /**
     * Emit request to update one movie
     * @param {object} data 
     * @param {function} success 
     */
    putMovie = function (data, success) {
        let dataToSend = {
            method: 'PUT',
            route: "movies",
            bJSON: true,
            id: data.id,
            title: data.title,
            created_at: data.created_at,
            duration: data.duration
        }
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
    }


    /**
     * Emit request to delete one movie
     * @param {object} data 
     * @param {function} success 
     */
    deleteMovie = function (data, success) {
        let dataToSend = {
            method: 'DELETE',
            route: "movies",
            bJSON: true,
            id: data.id,
        }
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
    }
}

/**
 * IIF (Immediately-invoked Function)
 * This the function scop where all the script will execute
 * It prevent of collision with other script 
 * listeners and ajax are object inside the scop of movies
 * templates, messageAlert and clear are object in the global scop from common.js file
 */
(function (templates, messageAlert, clear) {
    const listeners = new MoviesListeners();
    const ajax = new MoviesAjax();
    new Movies(
        templates,
        messageAlert, 
        clear, 
        listeners, 
        ajax
    );
})(templates, messageAlert, clear)



