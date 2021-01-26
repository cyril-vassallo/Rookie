/**
 * @Class 
 * Général scop for movies route
 */
class Movies {
    constructor(clear, listeners, ajaxMovies){
        this.clear = clear;
        this.listeners = listeners;
        this.ajaxMovies = ajaxMovies;
        this.data = {};
        this.StartScriptExecution()
    }
    
    StartScriptExecution = function(){
        this.listeners.handleClickOnSelectButtons(this.ajaxMovies.getMovie, this.successGetMovie);
        this.listeners.handleClickOnCreateButton(this.ajaxMovies.postMovie, this.successPostMovie);
        this.listeners.handleClickOnDeleteButton(this.ajaxMovies.deleteMovie, this.successDeleteMovie);
    }

    successGetMovie = function(response){
        let movie = response[0];
        console.log(movie);
        document.querySelector('#id_movie').value = movie.id;
        document.querySelector('#title_movie').value = movie.title;
        document.querySelector('#createdAt_movie').value = movie.created_at;
        document.querySelector('#duration_movie').value = movie.duration;
    }

    successPostMovie = function(response){
        console.log(response);
    }

    successDeleteMovie = function(response){
        console.log(response);
    }
}

/**
 * @Class 
 * Add event to DOM elements
 */
class Listeners {
    constructor(){}

    handleClickOnSelectButtons = function(getMovie, success){
        let data = {};
        let buttons = document.getElementsByClassName("selectButton");
        for(let i = 0; i < buttons.length; i++)
        {
            buttons[i].addEventListener('click', function(e){
                data.id = e.target.dataset.id; 
                getMovie(data, success)
            });
        } 
    }

    handleClickOnCreateButton = function(postMovie, success){
        let createButton =  document.querySelector("#btn_create");
        console.log(createButton);
        createButton.addEventListener('click', function(){
            let data = {
                title:  document.querySelector('#title_movie').value,
                created_at: document.querySelector('#createdAt_movie').value,
                duration: document.querySelector('#duration_movie').value,
            };
            postMovie(data, success)
        });
    }

    handleClickOnDeleteButton = function(deleteMovie, success){
        let deleteButton =  document.querySelector("#btn_delete");
        console.log(deleteButton);
        deleteButton.addEventListener('click', function(){
            let data = {
                id:  document.querySelector('#id_movie').value,
            };
            deleteMovie(data, success)
        });
    }
}


/**
 * @Class 
 * Clear field methods
 */
class Clear {
    constructor(){}

    clearMovieForm = function(){
        document.querySelector('#id_movie').value = '';
        document.querySelector('#title_movie').value = '';
        document.querySelector('#createdAt_movie').value = '';
        document.querySelector('#duration_movie').value = '';
    }
}

/**
 * @Class 
 * Ajax methods for movie routes
 */
class AjaxMovies {
    constructor(){}

    getMovie = function(data, success) {
        let dataToSend = {
            method : 'GET',
            route : "movies",
            bJSON : true, 
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
        .done(function(response) {
            success(response);
            
        })
        .fail(function(error) {
            console.log('error : ' + error.status);
        }); 
    }

    postMovie = function(data, success) {
        let dataToSend = {
            method : 'POST',
            route : "movies",
            bJSON : true, 
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
        .done(function(response) {
            success(response);
            
        })
        .fail(function(error) {
            console.log('error : ' + error.status);
        }); 
    }


    deleteMovie = function(data, success) {
        let dataToSend = {
            method : 'DELETE',
            route : "movies",
            bJSON : true, 
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
        .done(function(response) {
            success(response);
            
        })
        .fail(function(error) {
            console.log('error : ' + error.status);
        }); 
    }



}

const clear = new Clear();
const listeners = new Listeners();
const ajaxMovies =  new AjaxMovies(); 


(function(clear, listeners, ajaxMovies) {
    const movies = new Movies(clear, listeners, ajaxMovies);
})(clear, listeners, ajaxMovies)



