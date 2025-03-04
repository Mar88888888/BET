const express = require('express');
const router = express.Router();
const Issuance = require('../models/Issuance');

router.get('/', async (req, res) => {
  const issuances = await Issuance.find().populate('employee_id').populate('item_id');
  res.render('issuances', { issuances });
});

router.post('/', async (req, res) => {
  await Issuance.create(req.body);
  res.redirect('/issuances');
});

router.put('/:id', async (req, res) => {
  await Issuance.findByIdAndUpdate(req.params.id, req.body);
  res.redirect('/issuances');
});

router.delete('/:id', async (req, res) => {
  await Issuance.findByIdAndDelete(req.params.id);
  res.redirect('/issuances');
});

module.exports = router;
