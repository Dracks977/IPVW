/*=====================Initialisation=====================*/
var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);
const httpd = require('https');
var fs = require('fs');
var request = require('sync-request');

app.use('/static', express.static('public'));
app.get('/', function(req, res){
	res.sendFile('index.html', { root: __dirname });
});

io.on('connection', function(socket){
	socket.on('needip', function(data){
		console.log("new ip search from :" + socket.request.connection.remoteAddress + " >>>>> " + data);
		if (data == "Krypton")
			var res = request('GET', 'http://0.0.0.0/?action=get_info');
		else if  (data == "Neon")
			var res = request('GET', 'http://0.0.0.0/?action=get_info');
		else
			var res = request('GET', 'http://0.0.0.0/?action=get_info');
		res = JSON.parse(res.getBody('utf8'));
		socket.emit('ip_result', res);
	});
});

/*======================Start========================*/
http.listen(80, function(){
	console.log('listening on *:80');
});
