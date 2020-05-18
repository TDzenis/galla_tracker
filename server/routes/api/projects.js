const Router = require('express-promise-router');
const db = require('../../db')

const router = new Router()

//actual routes go here

//get project
router.get('/', async (req, res) => {
  const { rows } = await db.query('SELECT * FROM public."projects"')
  res.send(rows)
})

//add prject TO-DO
router.post('/', async (req, res) => { })

//delete project TO-DO
router.delete('/:id', async (req, res) => {
  let { id } = req.params;
  await db.query('DELETE FROM public."projects" WHERE id = $1', [id], (err) => {
    if (err) throw err;
  });
  res.status(200).send();
})
  
//update project TO-DO
router.put('/', async (req, res) => { })

// export our router to be mounted by the parent application
module.exports = router;