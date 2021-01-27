/**
 * @Class 
 * Général scop for the movies route
 */
class Movies {
    constructor(templates, messageAlert, clear, listeners, ajaxMovies) {
        this.templates = templates;
        this.messageAlert = messageAlert;
        this.clear = clear;
        this.listeners = listeners;
        this.ajaxMovies = ajaxMovies;
        this.data = {};
        this.StartScriptExecution()
    }

    /**
     * Add initial events 
     */
    StartScriptExecution = function () {
        this.listeners.handleClickOnCancelButton();
        this.listeners.handleClickOnEachCopyButton(this.ajaxMovies.getMovie, this.successGetMovie);
        this.listeners.handleClickOnCreateButton(this.ajaxMovies.postMovie, this.successPostMovie);
        this.listeners.handleClickOnDeleteButton(this.ajaxMovies.deleteMovie, this.successDeleteMovie);
        this.listeners.handleClickOnUpdateButton(this.ajaxMovies.putMovie, this.successPutMovie);
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
            this.listeners.handleClickOnEachCopyButton(this.ajaxMovies.getMovie, this.successGetMovie);
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
            this.listeners.handleClickOnEachCopyButton(this.ajaxMovies.getMovie, this.successGetMovie);
        } catch (e) {
            console.log(e);
        }
    }
}

/**
 * @Class 
 * Add event to DOM elements
 */
class Listeners {
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
 * Clear field methods
 */
class Clear {
    constructor() { }

    /**
     * clear all movie form input fields
     */
    clearMovieForm = function () {
        document.querySelector('#id_movie').value = '';
        document.querySelector('#title_movie').value = '';
        document.querySelector('#createdAt_movie').value = '';
        document.querySelector('#duration_movie').value = '';
    }
}

/**
 * @Class 
 * Give templates methods
 */
class Templates {
    constructor() { }

    /**
     * Provide a dynamic template string of one row of movie table
     * @param {object} movie
     * @return {string}
     */
    movieRow = function(movie) {
        return `         
            <tr data-id='${movie.id}'>
                <td>${movie.id}</td>
                <td>${movie.title}</td>
                <td>${movie.create_at}</td>
                <td>${movie.duration}</td>
                <td>
                    <button type="button" data-id="${movie.id}" class="btn btn-primary copyButton">
                        Select
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="8" y="8" width="12" height="12" rx="2"></rect>
                            <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                        </svg>
                    </button>
                </td>
            </tr>`;
    }

}

/***
 * @class
 * Message Alert
 */
class MessageAlert {

    /**
     * Display Message Alert into a specific node 
     * @param {string} where 
     * @param {string} message 
     * @param {*string} alertLevel 
     */
    display = function (where, message, alertLevel) {
        let template =
            `<div class="alert alert-${alertLevel} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>`;
        document.querySelector(where).innerHTML = template;
    }
}



/**
 * @Class 
 * Ajax methods for movie routes
 */
class AjaxMovies {
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
 * General scop instance of object
 */
const templates = new Templates();
const messageAlert = new MessageAlert();
const clear = new Clear();
const listeners = new Listeners();
const ajaxMovies = new AjaxMovies();


/**
 * IIF (Immediately-invoked Function)
 * This the function scop where all the script will execute
 * It prevent of collision with other script
 */
(function (templates, messageAlert, clear, listeners, ajaxMovies) {
    const movies = new Movies(
        templates,
        messageAlert, 
        clear, 
        listeners, 
        ajaxMovies
    );
})(templates, messageAlert, clear, listeners, ajaxMovies)



