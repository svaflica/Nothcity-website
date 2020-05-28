menu.onclick = function menu(){
	var x = document.getElementById('myTopnav');
	
	if(x.className === "topnav"){
		x.className += "response";
	} else{
		x.className = "topnav"
	}
}

$(function(){
	$(document).one('click', '.like-review', function(e) {
		$(this).html('<i class="fa fa-heart" aria-hidden="true"></i> You liked this');
		$(this).children('.fa-heart').addClass('animate-like');
	});
});

function likes(){
	alert('выы');
	var state;
	state = document.getElementById('like');
	if (state.checked) {
		alert('Выбран');
	}
	else {
		alert ('Не выбран');
	}
}