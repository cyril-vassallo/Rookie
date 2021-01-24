
class Movies {
    constructor(clear, listeners, ajaxMovies){
        this.clear = clear;
        this.listeners = listeners;
        this.ajaxMovies = ajaxMovies;
        this.data = {};
        this.StartExecution()
    }
    
    StartExecution = function(){
        
        console.log(this.listeners.addEventsOnSelectButtons(this.ajaxMovies.getMovie));
        
    }

    selectMovie = function(){
        this.data.id = document.querySelector('#id_8').innerHTML
        this.ajaxMovie.getMovie(this.data, this.successGetMovie)
    }

    successGetMovie = function(){
        console.log('Has been Selected from db!')
    }
}


class Listeners {
    constructor(){}

    addEventsOnSelectButtons = function(getMovie){
        let buttons = document.getElementsByClassName("selectButton");
        console.log(buttons)
        for(let i = 0; i < buttons.length; i++)
        {
           buttons[i].addEventListener('click', getMovie);
        }
            
    }
}


class Clear {
    constructor(){}

    clearMovieForm = function(){
        document.querySelector('#id_movie').value = '';
        document.querySelector('#title_movie').value = '';
        document.querySelector('#createdAt_movie').value = '';
        document.querySelector('#duration_movie').value = '';
    }
}


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
            url: "index.php",
            async: true,
            data: dataToSend,
            dataType: "json",
            cache: false,
        })
        .done(function(result) {
            console.log(result);
            success(result);
        })
        .fail(function(error) {
            console.log('error : ' + error.status);
        });
          
    }

}

const clear = new Clear();
const listeners = new Listeners();
const ajaxMovies =  new AjaxMovies(); 
const movies = new Movies(clear, listeners, ajaxMovies);
