const express = require('express')
const app = express()
const port = 3000
const fs = require('fs');

app.get('/', (req, res) => res.redirect("/login"))

app.get('/login', (req, res) => {
  fs.readFile('login.php', function(err, data) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(data);
    return res.end();
  });
})

app.get('/register', (req, res) => {
  fs.readFile('register.php', function(err, data) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(data);
    return res.end();
  });
})

app.get('/content', (req, res) => res.send('Content!'))

app.listen(port, () => console.log(`Example app listening at http://localhost:${port}`))