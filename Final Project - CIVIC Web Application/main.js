function civic(){
    alert("Welcome to CIVIC!");
    load();
}
document.querySelector("#btn-click").onclick = civic;

function cityAJAX(code){
    $.ajax({
        method:"GET",
        url: "https://wft-geo-db.p.rapidapi.com/v1/geo/cities/" + code,
        headers: {
            "x-rapidapi-host": "wft-geo-db.p.rapidapi.com",
            "x-rapidapi-key": "f526aee9b9msh9e7474f59ef2701p1664a3jsn038a6df2c169"
        }
    })
    .done(function(response){
        console.log(response);
        $('#cityTitle').html(response.data.city + " Details");
        $('#Country').html("Country: " + response.data.country);
        $('#State').html("State: " + response.data.region); 
        $('#StateAcronym').html("State Code: " + response.data.regionCode); 
        $('#Population').html("Population: " + response.data.population);
        $('#Latitude').html("Latitude: " + response.data.latitude);  
        $('#Longitude').html("Longitude: " + response.data.longitude); 
        console.log(response.data.city);
    })
    .fail(function(){
        console.log("ERROR");
    });
}

function load() {
    let choice = $("#city option:selected").val();
    console.log(choice);
    if(choice == "Los+Angeles"){
        cityAJAX("Q65");
    }else if(choice == "New+York"){
        cityAJAX("Q60");
    }else if(choice == "Chicago"){
        cityAJAX("Q1297");
    }
}

$("#city").on("change",function() {
    load(); 
})

function searchToggle() {
    var x = document.getElementById("#searchIt");
    if (x.style.display === "none") {
    x.style.display = "block";
    } else {
    x.style.display = "none";
    }
}

function addToggle() {
    var x = document.getElementById("#addIt");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

load();

    
