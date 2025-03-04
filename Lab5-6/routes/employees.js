const express = require('express');
const router = express.Router();
const Employee = require('../models/Employee');
const Issuance = require('../models/Issuance');

router.get('/', async (req, res) => {
  const employees = await Employee.find();
  res.render('employees', { employees });
});

router.post('/', async (req, res) => {
  await Employee.create(req.body);
  res.redirect('/employees');
});

router.put('/:id', async (req, res) => {
  await Employee.findByIdAndUpdate(req.params.id, req.body);
  res.redirect('/employees');
});

router.delete('/:id', async (req, res) => {
  await Issuance.deleteMany({ employee_id: req.params.id });
  await Employee.findByIdAndDelete(req.params.id);
  res.redirect('/employees');
});

module.exports = router;
