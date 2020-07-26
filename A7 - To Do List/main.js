//1. WEATHER FEATURES
//Define ajax method for the weather
function weatherAJAX(choice){
    $.ajax({
        method:"GET",
        url:"https://api.weatherbit.io/v2.0/current?city=" + choice + "&units=I&key=811c76db50a341a6b936af9005ac84bd",
    })
    .done(function(response){
        console.log(response)
        $("#temp").html(response.data[0].temp);
        $("#description").html(response.data[0].weather.description);
        $("#feeling").html(response.data[0].app_temp);
    })
    .fail(function(){
        console.log("ERROR");
    });
}
//Define load method (need to set city name!)
function load() {
    if (!localStorage.getItem("city")){
        localStorage.setItem("city", "Los Angeles");
        $("#city").val(localStorage.getItem("city"));
    }else{
        $("#city").val(localStorage.getItem("city"));
    }
    let choice = localStorage.getItem("city");
    //send the city that is selected!
    weatherAJAX(choice);
}
//Define on change method for weather/city
$("#city").on("change",function() {
    let city = $("#city option:selected").val();
    localStorage.setItem("city",city);
    load(); 
})

//2. LIST FUNCTIONALITY FEATURES
//Add functionality
$("#form").on("submit", function(event){
    event.preventDefault();
    //let item = $("#item").val();
    //let $lists = $(".todoList");
    //$lists.append("<li>"+item+"</li>");
    let item = $('input[name=item]').val();
    $('ul').append('<li><i class="far fa-square"></i><span class="lol">' + item + '</span></li>');
    $("form").trigger("reset");
});
//Strike Through functionality
$("#todoList").on("click", "span", function() {
	$(this).toggleClass("strike");
});
//Remove functionality
$("#todoList").on("click","i", function(){
	$(this).parent().fadeOut(300, function(){
		$(this).remove();
	});
});
//Slide functionality
$("#toggle").on("click", function() {
	$("#form").slideToggle();
});

load();