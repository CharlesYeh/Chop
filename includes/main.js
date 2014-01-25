
var id, latitude, longitude;
var map;
var msgIds = {};
var chatter;
var chatChecker;

var acker;

var views = new Array("#home", "#list", "#map", "#chat", "#chattersdiv");
function showView(view) {
	if (chatChecker) {
		clearInterval(chatChecker);
		chatChecker = null;
	}
	
	for (var i in views) {
		var v = views[i];
		$(v).css("display", (v == view) ? "block" : "none");
	}
}

var placeholders = new Array(
	"weird, hoohoo!",
	"addicted to giggling jk",
	"funny as a weasel",
	"super duper!!",
	"LOLing",
	"liking cheese",
	"loving it",
	"ME!",
	"sillylyly",
	"wanted by the FBI",
	"conquering the world",
	"clueless",
	"freeeeeee",
	"hanging bacon out the window",
	"like a boss",
	"speechless. haha no way",
	"doge, wow"
);


$(document).ready(function() {
	// create user id
	var idArray = new Array();
	for (var i = 0; i < 32; i++) {
		idArray.push(String.fromCharCode(65 + Math.floor(Math.random() * 26)));
	}
	id = idArray.join("");
	
	// load location
	getLocation();
	
	// setup clicks
	$("#btnpingOn").click(function() {
		setPingOn();
		acker = setInterval(setPingOn, 60000);
	});
	$("#btnpingOff").click(function() {
		setPingOff();
		clearInterval(acker);
	});
	$("#whos_free").click(showMap); 
	$("#map_to_list").click(showList);
	$("#chats_to_map").click(showMap);
	$("#chat_to_map").click(showMap);
	$("#list_to_map").click(showMap);
	$("#chatters").click(showChatters);
	$("#back_home, #back_home2").click(showHome);
	$("#blurb").val(randPlaceholder());
	$("#blurb").click(function() {
		$(this).val("");
		$(this).unbind('click');
	});
	
	$("#messager").keydown(function(e) {
		// pressed enter
    if (e.keyCode == 13) {
			$("#send").click();
		}
  });
	
	// setup initial view
	showView("#home");
});
function randPlaceholder() {
	return placeholders[Math.floor(Math.random() * placeholders.length)]
}
function showHome() {
	showView("#home");
}
function setPingOn() {
	// change btnping
	$.ajax({
		type: "POST",
		url: "api/pingOn.php",
		data: {
			user: id,
			blurb: $("#blurb").val(),
			longitude: longitude,
			latitude: latitude
		}
	});
	$("#btnpingOn").css("display", "none");
	$("#btnpingOff").css("display", "block");
}
function setPingOff() {
	$.ajax({
		type: "POST",
		url: "api/pingOff.php",
		data: {
			user: id
		}
	});
	$("#btnpingOn").css("display", "block");
	$("#btnpingOff").css("display", "none");
}
function showMap() {
	showView("#map");
	if (!map) {
		loadMapScript();
	}
	
	$.ajax({
		type: "POST",
		url: "api/list.php",
		data: {
			user: id,
			longitude: longitude,
			latitude: latitude
		}
	}).done(loadedMap);
}
function showChatters() {
	showView("#chattersdiv");
	$.ajax({
		type: "POST",
		url: "api/getChatters.php",
		data: {
			poster: id
		}
	}).done(loadedChatters);
}
function loadedChatters(msg) {
	var items = eval('(' + msg + ')');
	$("#chatterscont").empty();
	
	// populate list items
	for (var i in items) {
		$("#chatterscont").append(createListItem(items[i]));
	}
}
function showList() {
	showView("#list");
	$.ajax({
		type: "POST",
		url: "api/list.php",
		data: {
			user: id,
			longitude: longitude,
			latitude: latitude
		}
	}).done(loadedList);
}
function showChat(it) {
	msgIds[it.user] = 0;
	
	showView("#chat");
	$("#messages").empty();
	$("#send").unbind('click');
	$("#send").click(function() {
		$.ajax({
			type: "POST",
			url: "api/chat.php",
			data: {
				poster: id,
				receiver: it.user,
				message: $("#messager").val()
			}
		});
		$("#messager").val("");
	});
	chatter = it;
	loadChats();
	chatChecker = setInterval(loadChats, 3000);
}
function loadChats() {
	$.ajax({
		type: "POST",
		url: "api/getChats.php",
		data: {
			poster: id,
			receiver: chatter.user,
			lastId: msgIds[chatter.user]
		}
	}).done(loadedChat);
	$("#chatTitle").html("THIS INTERESTING PERSON IS: " + chatter.blurb);
}
function loadedChat(msg) {
	var items = eval('(' + msg + ')');
	
	for (var i in items) {
		var it = items[i];
		
		var bubble = $(document.createElement("div"));
		bubble.addClass("bubble");
		bubble.css("float", (it.poster == id) ? "left" : "right");
		bubble.css("text-align", (it.poster == id) ? "left" : "right");
		
		bubble.html(it.message);
		$("#messages").append(bubble);
		$("#messages").scrollTop($("#messages")[0].scrollHeight)
		
		msgIds[chatter.user] = it.id;
	}
}
var LOADED_DATA = 1;
var LOADED_API = 2;

var loaded = 0;
var loadedMsg = "";
function loadedMap(msg) {
	if (loaded != LOADED_API) {
		loaded = LOADED_DATA;
		loadedMsg = msg;
		return;
	}
	
	var items = eval('(' + msg + ')');
	
	for (var i in items) {
		var it = items[i];
		var d = coordToDistance(longitude, it.longitude, latitude, it.latitude);
		var ll = new google.maps.LatLng(it.latitude, it.longitude);
		
		var m = new google.maps.Marker({
			map: map,
			visible: true,
			position: ll
		});
		var infowindow = new google.maps.InfoWindow({
      content: "<a style='text-decoration: none;' href='javascript: showChat(" + JSON.stringify(it) + ")'><span style='font-size: 20px; color: #000;'>I AM " + it.blurb + "</span></a>",
			position: ll
	  });
		
		infowindow.open(map);
		
		(function(it) {
			google.maps.event.addListener(m, 'click', 
				function() {
					it.open(map);
				}
			);
		})(infowindow);
	}
	map.setZoom(18);
}
function loadedList(msg) {
	var items = eval('(' + msg + ')');
	$("#listcont").empty();
	
	// populate list items
	for (var i in items) {
		$("#listcont").append(createListItem(items[i]));
	}
}
function createListItem(it) {
	var d = coordToDistance(longitude, it.longitude, latitude, it.latitude);
	
	var div = $(document.createElement("div"));
	div.addClass("listitem");
	div.html("<div class='here'><img src='images/here.png'/></div><div class='blurbdiv'><span class='i_am'>I AM:</span><span class='blurbs'>" + it.blurb + "</span><br/><span class='dist'>"
					+ describeDistance(d) + "</span></div>");
	div.click({value: it}, function(evt) {
		showChat(evt.data.value);
	});
	return div;
}
function getLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(loadedPosition);
	}
	else {
		// not supported by browser
	}
}
function loadedPosition(position) {
	latitude = position.coords.latitude;
	longitude = position.coords.longitude;
}
function coordToDistance(lon1, lon2, lat1, lat2) {
	var R = 3959; // miles
	var dLat = (lat2-lat1) * 3.14 / 180;
	var dLon = (lon2-lon1) * 3.14 / 180;
	var lat1 = lat1 * 3.14 / 180;
	var lat2 = lat2 * 3.14 / 180;
	
	var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
					Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
	var d = R * c;
	return d;
}
function initialize() {
  var mapOptions = {
    zoom: 17,
		streetViewControl: false,
		mapTypeControl: false,
    center: new google.maps.LatLng(latitude, longitude)
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	
	if (loaded == LOADED_DATA) {
		loadedMap(loadedMsg);
	}
	else {
		loaded = LOADED_API;
	}
}
function loadMapScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' +
      'callback=initialize';
  document.body.appendChild(script);
}
function describeDistance(d) {
	var miles = Math.floor(d);
	var feet = Math.floor((d - miles) * 5280);
	var str = "";
	if (miles > 0) {
		str = miles + " miles";
		if (feet > 0) {
			str += ", ";
		}
	}
	if (feet > 0) {
		str += feet + " feet";
	}
	if (str == "") {
		str = "Right next to you!";
	}
	return str;
}
