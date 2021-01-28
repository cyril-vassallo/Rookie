/**
 * ----------------------------------
 *              COMMON
 * ----------------------------------
 * @author Cyril VASSALLO
 * In this file you will find:
 * - store classes shared between different pages
 * - common instances of object in general scop of the application
 * /

/**
 * @class
 * Message Alert
 */
class MessageAlert {
    constructor() { }
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
 * Give templates methods
 */
class Templates {
    constructor() { }

    /**
     * Provide a dynamic template string of one row of movie table
     * @param {object} movie
     * @return {string}
     */
    movieRow = function (movie) {
        const timeZone = 'Europe/Kaliningrad';
        const timeZoneOffset = '+02:00';  

        return `         
            <tr data-id='${movie.id}'>
                <td>${movie.id}</td>
                <td>${movie.title}</td>
                <td>${movie.created_at.toLocaleString('fr-FR', { format : 'd/m/y' })}</td>
                <td>${movie.duration}</td>
                <td>
                    <button type="button" data-id="${movie.id}" class="btn btn-primary copyButton">
                        Select
                        <img src="public/assets/svg/tabler-icon-copy.svg" alt="select button"/>
                    </button>
                </td>
            </tr>`;
    }
    /**
     * Provide a dynamic template string of one row of actor table
     * @param {object} actor
     * @return {string}
     */
    actorRow = function (actor) {
        // to do template of a actor table row
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

    /**
     * clear all actor form input fields
     */
    clearActorForm = function () {
        //To do actor clear input
    }
}

/**
 * Instances of objects in the general scop 
 */
const templates = new Templates();
const messageAlert = new MessageAlert();
const clear = new Clear();

