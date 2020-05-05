var path = require('path');

const express = require('express')
const session = require('express-session')
const app = express()
const port = process.env.PORT || 3000;

const fs = require('fs')
const mysql = require('mysql');

const bcrypt = require('bcrypt') //https://www.npmjs.com/package/bcrypt
const saltRounds = 10

try {
  const dbSettings = import('./config.json')
} catch (err) {
  console.log(err);
}






const con = mysql.createConnection(dbSettings);
var signedIn = false;

app.use(express.urlencoded());

// Parse JSON bodies (as sent by API clients)
app.use(express.json());

app.get('/', (req, res) => { 

  res.redirect("/main")
})

app.get('/logOutUser', (req, res) => { 
  signedIn = false;
  res.redirect("/login")
})

app.get('/login', (req, res) => {
  if (signedIn == true) {
    res.redirect("/main")
  } else {
    res.sendFile(path.join(__dirname + '/login.html'));
  }
  
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
              signedIn = true;
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
  res.sendFile(path.join(__dirname + '/register.html'));
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

app.get('/main', (req, res) => {
  if (signedIn == true) {
    res.sendFile(path.join(__dirname + '/main.html'));
  } else {
    res.redirect("/login")
  }
  
})

//main front-end js file
app.get('/js/main.js', (req, res) => {
  res.sendFile(__dirname + '/js/main.js');
});

app.get('/favicon.ico', (req, res) => {
  res.sendFile(__dirname + '/favicon.ico');
});

app.get('/getAllTickets', (req, res) => {
  let getAllTicketsSql = "SELECT * FROM `ticket` LIMIT 12;" //replace LIMIT 3 with how many records you want returned
  
  con.query(getAllTicketsSql, (err, result) => {
    
    if (err) throw err;
    if (result.length > 0) {
      res.json(result);
      console.log("Results loaded");
    } else {
      returnJson(res, "fail", "No tickets found!");
    }
  })
});

app.post('/updateTicket', (req, res) => {
  /*
  all fields in the response body
  ticketId
  ticketName
  ticketDescription
  ticketDeadline
  ticketAssignedTo
  ticketStatus
  ticketEstimatedTimeNeeded
  ticketImportance
  */
  let ticket = req.body.ticket;
  let updateSql = "UPDATE ticket SET name = ?, description = ?, deadline = ?, assigned_to = ?, status = ?, estimated_time_needed = ?, importance = ? WHERE id = ? ";

  con.query(updateSql, [ticket.ticketName, ticket.ticketDescription, ticket.ticketDeadline,
    ticket.ticketAssignedTo, ticket.ticketStatus,
    ticket.ticketEstimatedTimeNeeded, ticket.ticketImportance, ticket.ticketId], (err) => { 
      if (err) throw err;
  })
  returnJson(res, "ok", "")
  con.close
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