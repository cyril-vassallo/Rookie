/**
 * @Class 
 * Général scop for movies route
 */
class Movies {
    constructor(messageAlert, clear, listeners, ajaxMovies){
        this.messageAlert = messageAlert;
        this.clear = clear;
        this.listeners = listeners;
        this.ajaxMovies = ajaxMovies;
        this.data = {};
        this.StartScriptExecution()
    }
    
    StartScriptExecution = function(){
        this.listeners.handleClickOnCancelButton();
        this.listeners.handleClickOnEachCopyButton(this.ajaxMovies.getMovie, this.successGetMovie);
        this.listeners.handleClickOnCreateButton(this.ajaxMovies.postMovie, this.successPostMovie);
        this.listeners.handleClickOnDeleteButton(this.ajaxMovies.deleteMovie, this.successDeleteMovie);
        this.listeners.handleClickOnUpdateButton(this.ajaxMovies.putMovie, this.successPutMovie);
    }

    successGetMovie = function(response){
        let movie = response[0];
        document.querySelector('#id_movie').value = movie.id;
        document.querySelector('#title_movie').value = movie.title;
        document.querySelector('#createdAt_movie').value = movie.created_at;
        document.querySelector('#duration_movie').value = movie.duration;
    }

    successPostMovie = function(response){
        try{
            let movie = response[0];
            console.log(`The movie ${movie.title} has been created`);
            //window.location = 'movies';
        }catch(e){
            console.log(e);
            //window.location = 'movies';
        }
           
    }

    successDeleteMovie = function(response){
        try{
            let movie = response[0];
            let message = `The movie | <em>${movie.title}</em> | has been remove from database`;
            document.querySelector(`tr[data-id="${movie.id}"]`).remove();
            messageAlert.display('#alertMovie', message , 'danger')
            clear.clearMovieForm();
        }catch(e){
            window.location = 'movies';
        }
    }

    successPutMovie = function(response){
        try{
            let movie = response[0];
            console.log(`The movie ${movie.title} has been updated`);
            //window.location = 'movies';
        }catch(e){
            //window.location = 'movies';
        }
    }
}

/**
 * @Class 
 * Add event to DOM elements
 */
class Listeners {
    constructor(){}

    handleClickOnEachCopyButton = function(getMovie, success){
        let data = {};
        let copyButtons = document.getElementsByClassName("copyButton");
        for(let i = 0; i < copyButtons.length; i++)
        {
            copyButtons[i].addEventListener('click', function(e){
                data.id = e.target.dataset.id; 
                getMovie(data, success)
             
            });
        } 
    }

    handleClickOnCreateButton = function(postMovie, success){
        let createButton =  document.querySelector("#btn_create");
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
        deleteButton.addEventListener('click', function(){
            let data = {
                id:  document.querySelector('#id_movie').value,
            };
            deleteMovie(data, success)
        });
    }

    handleClickOnCancelButton = function(){
        let cancelButton =  document.querySelector("#btn_cancel");
        cancelButton.addEventListener('click', function(){
            clear.clearMovieForm();
        });
    }

    handleClickOnUpdateButton = function(putMovie, success){
        let updateButton =  document.querySelector("#btn_update");
        updateButton.addEventListener('click', function(){
            let data = {
                id: document.querySelector('#id_movie').value,
                title:  document.querySelector('#title_movie').value,
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
    constructor(){}

    clearMovieForm = function(){
        document.querySelector('#id_movie').value = '';
        document.querySelector('#title_movie').value = '';
        document.querySelector('#createdAt_movie').value = '';
        document.querySelector('#duration_movie').value = '';
    }
}

/***
 * @class
 * Message Alert
 */
class MessageAlert {

  /**
   * Display Message Alert
   * @param {string} where 
   * @param {string} message 
   * @param {*string} alertLevel 
   */
    display = function(where, message, alertLevel){
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

    putMovie = function(data, success) {
        let dataToSend = {
            method : 'PUT',
            route : "movies",
            bJSON : true, 
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

const messageAlert = new MessageAlert();
const clear = new Clear();
const listeners = new Listeners();
const ajaxMovies =  new AjaxMovies(); 


(function(messageAlert, clear, listeners, ajaxMovies) {
    const movies = new Movies(messageAlert, clear, listeners, ajaxMovies);
})(messageAlert, clear, listeners, ajaxMovies)



