const express = require('express')
const session = require('express-session')
const app = express()
const port = 3000

const fs = require('fs')
const mysql = require('mysql');

const bcrypt = require('bcrypt')
const saltRounds = 10

const dbSettings = require('./config.json')

const con = mysql.createConnection(dbSettings);

app.use(express.urlencoded());

// Parse JSON bodies (as sent by API clients)
app.use(express.json());

app.get('/', (req, res) => res.redirect("/login"))

app.get('/login', (req, res) => {
  fs.readFile('login.html', (err, data) => {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(data);
    return res.end();
  });
})
  
app.post('/logInUser', (req, res) => {
  let con = mysql.createConnection(dbSettings);
  let password = req.body.user.password;
  let email = req.body.user.email;
  let checkUserSql = "SELECT * FROM user WHERE email = ?;";
  let getPasswordSql = "SELECT password FROM user WHERE email = ?;"

  con.connect((err) => {
    if (err) throw err;
    con.query(checkUserSql, email, (err, result) => { 
      if (err) throw err;
      if (result.length > 0) { 
        con.query(getPasswordSql, email, (err, result) => { 
          if (err) throw err;
          bcrypt.compare(password, result[0].password).then((result) => {
            if (result) {
              returnJson(res, "ok", "");
            } else {
              returnJson(res, "fail", "Password is not correct");
            }
          })
        })
      } else {
        returnJson(res, "fail", "User does not exist, please register.");
      }
    })
  })
})

app.get('/register', (req, res) => {
  fs.readFile('register.html', (err, data) => {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(data);
    return res.end();
  });
})

// Takes email and password from the request, hashes the password and 
// creates the DB entry for a new user
app.post('/registerUser', (req, res) => {
  let con = mysql.createConnection(dbSettings);
  let password = req.body.user.password;
  let email = req.body.user.email;

  con.connect( (err) => {
    if (err) throw err;
    
    bcrypt.hash(password, saltRounds, (err, hash) => {
      let checkUserSql = "SELECT * FROM user WHERE email = ?;";
      const registerUserSql = "INSERT INTO user(email, password) VALUES (?);";
      const hashedPassword = "";
      const newUser = [email, hash];

      con.query(checkUserSql, email, (err, result) => {
        if (err) throw err;
        if (result.length > 0) { 
          console.log("user exists");
          returnJson(res, "fail", "Email already exists")
        } else {
          con.query(registerUserSql, [newUser], (err, result) => {
            if (err) throw err;
            console.log("New user added");
            returnJson(res, "ok", "");
          });
        }
      });
    });
  });
  con.close
})

app.get('/content', (req, res) => {
  fs.readFile('main.html', (err, data) => {
    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(data);
    return res.end();
  });
})

app.listen(port, () => console.log(`App listening at http://localhost:${port}`))

function returnJson(res, status, err) {
  let responseData = {
    status : status,
    error : err
  }
  res.json(responseData);
}