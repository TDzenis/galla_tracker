const Router = require('express-promise-router');
const db = require('../../db')

const router = new Router()


//actual routes go here

//get ticket
router.get('/', async (req, res) => {
  const { rows } = await db.query('SELECT * FROM public."tickets"')
  res.send(rows);
})

//add ticket
router.post('/', async (req, res) => { 
  let data = req.body;
  
  let addTicket = {
    name: 'add-ticket',
    text: 'INSERT INTO public."tickets" (name, description, created_on, completed_on, deadline, \
      completed_by, created_by, assigned_to, status, importance, project_id) \
    VALUES ($1, $2, now(), $3, $4, $5, $6, $7, $8, $9, $10)',
    values: [data.name, data.description, data.completed_on, data.deadline, data.completed_by,
    data.created_by, data.assigned_to, data.status, data.importance, data.project_id]
  }
  
  await db.query(addTicket, (err) => {
    if (err) throw err;
    res.status(201).send();
  })
})

//delete ticket
router.delete('/:id', async (req, res) => {
  let { id } = req.params;
  await db.query('DELETE FROM public."tickets" WHERE id = $1', [id], (err) => {
    if (err) throw err;
  });
  res.status(200).send();
})

//update ticket TO-DO
router.put('/:id', async (req, res) => {
  res.status(201).send();
})

// export our router to be mounted by the parent application
module.exports = router;