//ON LOAD => By default, movies that are playing in theaters now are displayed
window.onload = function(){
    let url = "https://api.themoviedb.org/3/movie/now_playing?api_key=bcabe54044b9d877b5aea6002e5bcb02&language=en-US&page=1";
    ajax(url, displayResult);
}

//ON SEARCH => Based on my keyword, movies are displayed.
document.querySelector("#search-form").onsubmit = function(){
    event.preventDefault();
    let keyword = document.querySelector("#search-id").value;
    //Now, search the api with the keyword!
    let url = "https://api.themoviedb.org/3/search/movie?api_key=bcabe54044b9d877b5aea6002e5bcb02&language=en-US&query=" + keyword + "&page=1&include_adult=true";
    ajax(url, displayResult);
}

//AJAX FUNCTIONALITY. Mostly repurposed from lecture.
function ajax(url, displayResult) {
	let httpRequest = new XMLHttpRequest();
	httpRequest.open("GET", url);
	httpRequest.send();
	httpRequest.onreadystatechange = function() {
		if (httpRequest.readyState == httpRequest.DONE){
			if(httpRequest.status == 200) {
                //This will be my displayResult function.
				displayResult(httpRequest.responseText);
			}
			else {
				console.log("AJAX Error!!");
				console.log(httpRequest.status)
			}
		}
	}
}

//This is the meat of my Javascript. Here I parse the JSON response and fix my webpage in real time. 
function displayResult(responseText){
    let response = JSON.parse(responseText);
    console.log(response);
    //Resolve the results row (#results). Now I will have updated numbers.
    let shown = document.querySelector("#results-shown")
    let total = document.querySelector("#results-total");
    shown.innerHTML = response.results.length;
    total.innerHTML = response.total_results;
    //Clear all existing movie to be replaced.
    let movies = document.querySelector("#movies");
    while (movies.hasChildNodes()) {
      movies.removeChild(movies.lastChild);
    }
    
    //THIS IS THE MOST IMPORTANT PART
    //I use a for loop to create objects one by one, adding all the class specifications I need in order to satisfy the layout requirements
    for (let i = 0; i < response.results.length; i++) {
        //SETUP
        let item = document.createElement("div");
        //Sizing and spacing classes
        item.classList.add("center");
        item.classList.add("col-6");
        item.classList.add("col-md-4");
        item.classList.add("col-lg-3");
        //I will edit this item class in CSS to have proper styling
        item.classList.add("item");

        //STANDARD Movie Details: Image, Title, Release Date
        let standardContainer = document.createElement("div");
        standardContainer.classList.add("standard-container");
        //1. Image 
        let image = document.createElement("img");
        if(response.results[i].poster_path == null){
            image.src = "NA.jpg";
        }
        else{
            imageUrl = "https://image.tmdb.org/t/p/w500/"+response.results[i].poster_path;
            image.src = imageUrl;
        }
        //2. Title
        let title = document.createElement("p");
        title.classList.add("font-weight-bold")
        title.innerHTML = response.results[i].title;
        //3. Release Date
        let date = document.createElement("p");
        date.innerHTML = response.results[i].release_date;
        //MERGE all the standard details into my container object.
        standardContainer.appendChild(image);
        standardContainer.appendChild(title);
        standardContainer.appendChild(date);

        //HOVER Movie Details: rating, vote total, synopsis (< 200 chars)
        let hoverContainer = document.createElement("div");
        hoverContainer.classList.add("hover-container");
        //This contains my hover portion inside the movie poster. Automatically resizes every time!
        image.onload = function() {
            standardContainer.style.width = image.width+"px";
            hoverContainer.style.width = image.width+"px";
            hoverContainer.style.height = image.height+"px";
        }
        window.onresize = function() {
            standardContainer.style.width = image.width+"px";
            hoverContainer.style.width = image.width+"px";
            hoverContainer.style.height = image.height+"px";
        }
        
        //1. Rating
        let rating = document.createElement("p");
        rating.innerHTML = "Rating: " + response.results[i].vote_average;
        //2. Votes
        let votes = document.createElement("p");
        votes.innerHTML = "Number of Votes: " + response.results[i].vote_count;
        //3. Synopsis
        let synopsis = document.createElement("p");
        if (response.results[i].overview.length > 200){
            synopsis.innerHTML = "Overview: " + response.results[i].overview.substring(0, 200) + "...";
        }
        else{
            synopsis.innerHTML = "Overview: " + response.results[i].overview;
        }
        
        //MERGE all the hidden details into my container object. 
        hoverContainer.appendChild(rating);
        hoverContainer.appendChild(votes);
        hoverContainer.appendChild(synopsis);
        
        //FINAL MERGE
        standardContainer.appendChild(hoverContainer);
        item.appendChild(standardContainer);
        movies.appendChild(item);
    }
}