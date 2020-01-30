var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);

server.listen(5979);

app.get('/', function (req, res) {
  res.sendFile(__dirname + '/public/index.html');
});

io.on('connection', function (socket) {
  socket.on('quick bid', function (data) {
    console.log(data);
    io.emit('has quick bid', data);
  });
  socket.on('custom bid', function (data) {
    console.log(data);
    io.emit('has custom bid', data);
  });
  socket.on('has bid data for seller',function(data){
    io.emit('data for seller', data);
  });
});