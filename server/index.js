const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();


//Middleware
app.use(bodyParser.json());
app.use(cors());
app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
  extended: true
}));

const users = require('./routes/api/users');
const tickets = require('./routes/api/tickets');
const projects = require('./routes/api/projects');
const companies = require('./routes/api/companies');

app.use('/api/users/', users);
app.use('/api/tickets', tickets);
app.use('/api/projects', projects);
app.use('/api/companies', companies);

const port = process.env.PORT || 5000;

app.listen(port, () => console.log(`Server started on port ${port}`));