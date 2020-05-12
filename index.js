const path = require('path')
const fs = require('fs')

const express = require('express')
const session = require('express-session')
const app = express()
const port = process.env.PORT || 3000;

const { Pool, Client } = require('pg')
const pool = new Pool()

const bcrypt = require('bcrypt') //https://www.npmjs.com/package/bcrypt
const saltRounds = 10

var signedIn = false;

const createUserTableSQL = 'CREATE TABLE "user" ( \
  id SERIAL, \
  name VARCHAR(15), \
  last_name VARCHAR(15), \
  email VARCHAR(50) NOT NULL, \
  password TEXT NOT NULL, \
  company_id INTEGER, \
  permission_level INTEGER, \
  ticket_id TEXT, \
  project_id TEXT, \
  PRIMARY KEY (id) \
);';

const createProjectTableSQL = 'CREATE TABLE "project" ( \
  id SERIAL, \
  name VARCHAR(30) NOT NULL, \
  description TEXT NOT NULL, \
  ticket_id JSON, \
  company_id JSON NOT NULL, \
  created_by INT NOT NULL, \
  status INTEGER NOT NULL, \
  created_on TIMESTAMP, \
  finished_on TIMESTAMP, \
  deadline TIMESTAMP, \
  PRIMARY KEY (id) \
);';

const createTicketTableSQL = 'CREATE TABLE "ticket" ( \
  id SERIAL, \
  name VARCHAR(60) NOT NULL, \
  description TEXT, \
  img BYTEA, \
  created_on TIMESTAMP, \
  completed_on TIMESTAMP, \
  deadline TIMESTAMP, \
  completed_by JSON, \
  created_by JSON, \
  assigned_to JSON, \
  status INTEGER, \
  importance INTEGER NOT NULL, \
  project_id INT NOT NULL, \
  estimated_time_needed INTERVAL, \
  PRIMARY KEY (id) \
);';

const createCompanyTableSQL = 'CREATE TABLE "company" ( \
  id SERIAL, \
  name VARCHAR(30) NOT NULL, \
  admin JSON NOT NULL, \
  employees_id JSON NOT NULL, \
  project_id JSON, \
  created_on TIMESTAMP, \
  PRIMARY KEY (id) \
);';


pool.query('SELECT * FROM "user"', (err, response) => { 
  if (err) {
    console.error(err);
    pool.query(createUserTableSQL, (err) => { if (err) throw err; });
    pool.query(createCompanyTableSQL, (err) => { if (err) throw err; });
    pool.query(createProjectTableSQL, (err) => { if (err) throw err; });
    pool.query(createTicketTableSQL, (err) => { if (err) throw err; });
    console.log("Tables created!");
  } else { 
    console.log("Tables exist");
  }
})

app.use(express.urlencoded());

// Parse JSON bodies (as sent by API clients)
app.use(express.json());

//main front-end js file
app.get('/js/main.js', (req, res) => {
  res.sendFile(__dirname + '/js/main.js');
});

//favicon.ico
app.get('/favicon.ico', (req, res) => {
  res.sendFile(__dirname + '/favicon.ico');
});

//landing page
app.get('/', (req, res) => { 
  res.redirect("/main")
})

//signs out user
app.get('/logOutUser', (req, res) => { 
  signedIn = false;
  res.redirect("/login")
})

//checks if login info is saved, otherwise displays login page
app.get('/login', (req, res) => {
  if (signedIn == true) {
    res.redirect("/main")
  } else {
    res.sendFile(path.join(__dirname + '/login.html'));
  }
  
})
  
//signs in user
app.post('/logInUser', (req, res) => {
  let password = req.body.user.password;
  let email = req.body.user.email;

  let checkUserSql = {
    name: 'check-if-user-exists-login',
    text: 'SELECT * FROM public."user" WHERE email = $1',
    values: [email]
  }

  let getPasswordSql = {
    name: 'check-if-password-correct',
    text: 'SELECT password FROM "user" WHERE email = $1',
    values: [email]
  }

  pool.query(checkUserSql, (err, response) => {
    if (err) {
      console.error(err);
      returnJson(res, "fail", "User not found");
    } else {
      bcrypt.compare(password, response.rows[0].password).then((result) => {
        if (result) {
          returnJson(res, "ok", "");
          signedIn = true;
        } else {
          returnJson(res, "fail", "Password is not correct");
        }
      })
    }
  })
})

//displays register page
app.get('/register', (req, res) => {
  res.sendFile(path.join(__dirname + '/register.html'));
})

// Takes email and password from the request, hashes the password and 
// creates the DB entry for a new user
app.post('/registerUser', (req, res) => {
  let password = req.body.user.password;
  let email = req.body.user.email;
    
    bcrypt.hash(password, saltRounds, (err, hash) => {
      const hashedPassword = "";
      const newUser = [email, hash];
      
      let checkUserSql = {
        name: 'check-if-user-exists',
        text: 'SELECT * FROM "user" WHERE email = $1',
        values: [email]
      }
      
      let registerUserSql = {
        name: 'new-user',
        text: 'INSERT INTO "user"(email, password) VALUES ($1, $2) ',
        values: newUser
      }
    
      pool.query(checkUserSql,  (err, response) => {
        if (err) {
          console.error(err);
        } else {
          if (response.rows.length > 0) {
            console.log("user exists");
            returnJson(res, "fail", "Email already exists");
          } else {
            pool.query(registerUserSql,  (err) => {
              if (err) {
                console.error(err);
              } else {
                console.log("New user added");
                returnJson(res, "ok", "");
              }
            })
          }
        }
      })
    });
})

//main content page
app.get('/main', (req, res) => {
  if (signedIn == true) {
    res.sendFile(path.join(__dirname + '/main.html'));
  } else {
    res.redirect("/login")
  }
  
})

//returns all tickets that meet the criteria (currently returns all tickets in db)
app.get('/getAllTickets', (req, res) => {
  let getAllTicketsSql = "SELECT * FROM ticket LIMIT 12;" //replace LIMIT # with how many records you want returned
  
  pool.query(getAllTicketsSql, (err, response) => { 
    if (err) throw err;
    if (response.rows.length > 0) {
      res.json(response.rows);
      console.log("Results loaded");
    } else {
      returnJson(res, "fail", "No tickets found!");
    }
  });
});

app.post('/updateTicket', (req, res) => {
  returnJson(res, "ok", "")
  let ticket = req.body;

  console.log(req.body);

  let updateSql = {
    name: 'update-ticket',
    text: 'UPDATE ticket SET name = $1, description = $2 WHERE id = $3;',
    values: [ticket.ticketName, ticket.ticketDescription, ticket.ticketId]
  };

  pool.query(updateSql, (err, response) => { 
    if (err) throw err;
  });
});

app.listen(port, () => console.log(`App listening at http://localhost:${port}`))

// returns a response containing status and error message if any
function returnJson(res, status, err) {
  let responseData = {
    status : status,
    error : err
  }
  res.json(responseData);
}