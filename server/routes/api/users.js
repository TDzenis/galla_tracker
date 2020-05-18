const Router = require('express-promise-router');
const db = require('../../db')

const router = new Router()
//actual routes go here

//get user
router.get('/', async (req, res) => {
  const { rows } = await db.query('SELECT * FROM public."users"')
  res.send(rows)
})

//add user TO-DO
router.post('/', async (req, res) => { })

//delete user TO-DO
router.delete('/:id', async (req, res) => {
  let { id } = req.params;
  await db.query('DELETE FROM public."users" WHERE id = $1', [id], (err) => {
    if (err) throw err;
  });
  res.status(200).send();
})

//update user TO-DO
router.put('/', async (req, res) => { })

// export our router to be mounted by the parent application
module.exports = router;