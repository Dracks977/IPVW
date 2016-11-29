/*=====================Initialisation=====================*/
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
const httpd = require('https');
var fs = require('fs');
var requestSync = require("request-sync");

app.use(express.static('public'));
app.get('/', function(req, res){
	res.sendFile('index.html', { root: __dirname });
});

io.on('connection', function(socket){
	console.log('a user connected {' + socket.request.connection.remoteAddress + "}");

	socket.on('disconnect', function(){
		console.log('user disconnected ' + socket.request.connection.remoteAddress);
	});
	socket.on('needip', function(data){
		console.log("new search incoming from :" + socket.request.connection.remoteAddress + " >>>>> " + data);
		var reponse = requestSync("http://192.168.0.1/?action=get_info");
		console.dir(response);
		// var f_rep = JSON.parse(reponse.body).hits;
		// var f_fac = JSON.parse(reponse.body).groups;
		// var tab_rep = [f_rep, f_fac];
		// var f_suggest = JSON.parse(reponse.body).spellCheckSuggestions.suggestions;
		// if (JSON.parse(reponse.body).nhits > 0)
		// 	socket.emit('result', tab_rep);
		// else
		// 	socket.emit('No_Result');
		// socket.emit('Rsugest', f_suggest);
	});
	
});

/*======================Start========================*/
http.listen(80, function(){
	console.log('listening on *:80');
});
