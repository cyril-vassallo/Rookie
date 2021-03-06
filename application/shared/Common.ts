import type { MovieType } from '../pages/movies/MovieType';
/**
 * ----------------------------------
 *              COMMON.TS
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

    /**
     * Display Message Alert into a specific node 
     */
    display = function (where: string, message: string, alertLevel: string) {
        let el: HTMLElement;
        let template: string =
            `<div class="alert alert-${alertLevel} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>`;
        el = document.querySelector(where) as HTMLElement;
        el.innerHTML = template;
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
     */
    movieRow = function (movie: MovieType) {
        const timeZone = 'Europe/Kaliningrad';
        const timeZoneOffset = '+02:00';  

        return`         
            <tr data-id='${movie.id}'>
                <td hidden>${movie.id}</td>
                <td>${movie.title}</td>
                <td>${movie.created_at.toLocaleString()}</td>
                <td>${movie.duration}</td>
                <td>
                    <button type="button" data-id="${movie.id}" class="btn btn-primary copyButton">
                        Select
                    </button>
                </td>
            </tr>`;
    }

}


/**
 * @Class 
 * Clear field methods
 */
class Clear {
    
    private idMovieInput: HTMLInputElement;
    private titleMovieInput: HTMLInputElement;
    private createdAtMovieInput: HTMLInputElement;
    private durationMovieInput: HTMLInputElement;

    constructor() { 
        this.idMovieInput = document.querySelector('#id_movie') as HTMLInputElement;
        this.titleMovieInput = document.querySelector('#title_movie') as HTMLInputElement;
        this.createdAtMovieInput = document.querySelector('#createdAt_movie') as HTMLInputElement;
        this.durationMovieInput  = document.querySelector('#duration_movie') as HTMLInputElement;
    }

    /**
     * clear all movie form input fields
     */
    clearMovieForm =  () => {

        this.idMovieInput.value= '';
        this.titleMovieInput.value = '';
        this.createdAtMovieInput.value = '';
        this.durationMovieInput.value= '';
    }

    /**
     * clear all actor form input fields
     */
    clearActorForm =  () => {
        //To do actor clear input
    }
}


/**
 *  Instances of objects in the general scop 
*/
const templates = new Templates();
const messageAlert = new MessageAlert();
const clear = new Clear();





