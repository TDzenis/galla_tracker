const Router = require('express-promise-router');
const db = require('../../db')

const router = new Router()
//actual routes go here

//get company
router.get('/', async (req, res) => {
  const { rows } = await db.query('SELECT * FROM public."companies"')
  res.send(rows)
})

//add company TO-DO
router.post('/', async (req, res) => { })

//delete company TO-DO
router.delete('/:id', async (req, res) => {
  let { id } = req.params;
  await db.query('DELETE FROM public."companies" WHERE id = $1', [id], (err) => {
    if (err) throw err;
  });
  res.status(200).send();
})
  
//update company TO-DO
router.put('/', async (req, res) => { })

// export our router to be mounted by the parent application
module.exports = router;