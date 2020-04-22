const express = require('express')
const app = express()
const port = 3000
const fs = require('fs')
const mysql = require('mysql');


app.get('/', (req, res) => res.redirect("/login"))

app.get('/login', (req, res) => {
  fs.readFile('login.html', function(err, data) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(data);
    return res.end();
  });
})

app.get('/register', (req, res) => {
  fs.readFile('register.html', function(err, data) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(data);
    return res.end();
  });
})

app.get('/registerUser', (req, res) => {
  
})

app.get('/content', (req, res) => {
  fs.readFile('main.html', function(err, data) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(data);
    return res.end();
  });
})

app.listen(port, () => console.log(`App listening at http://localhost:${port}`))