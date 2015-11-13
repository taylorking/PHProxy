var express = require('express');
var app = express();
var bp = require('body-parser');
var jp = bp.json();
app.get('/', function(req, res) {
  console.log(req);
  res.send('Hello for GET from node.js');
});
app.delete('/', function(req,res) {
  res.send('Hello for DELETE from node.js');
});
app.post('/cat', jp,  function(req, res) {
  console.log(req);
  res.send('Got your cat!');
});
app.post('/', function(req, res) {
  res.send('Hello for POST from node.js');
});
app.listen(5000);
