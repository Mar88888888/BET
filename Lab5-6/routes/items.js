const express = require('express');
const router = express.Router();
const Item = require('../models/Item');
const Issuance = require('../models/Issuance');

router.get('/', async (req, res) => {
  const items = await Item.find();
  res.render('items', { items });
});

router.post('/', async (req, res) => {
  await Item.create(req.body);
  res.redirect('/items');
});

router.put('/:id', async (req, res) => {
  await Item.findByIdAndUpdate(req.params.id, req.body);
  res.redirect('/items');
});

router.delete('/:id', async (req, res) => {
  await Issuance.deleteMany({ item_id: req.params.id });
  await Item.findByIdAndDelete(req.params.id);
  res.redirect('/items');
});

module.exports = router;
