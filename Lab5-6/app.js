const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
const path = require('path');
const { engine } = require('express-handlebars');
const { graphqlHTTP } = require('express-graphql');
const schema = require('./graphql/schema');
const resolvers = require('./graphql/resolvers');
require('dotenv').config();

const Item = require('./models/Item');
const Employee = require('./models/Employee');
const Issuance = require('./models/Issuance');

const app = express();
app.use(express.json());
app.use(cors());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

app.engine('hbs', engine({
  extname: 'hbs',
  runtimeOptions: {
    allowProtoPropertiesByDefault: true,
    allowProtoMethodsByDefault: true
  }
}));



app.use('/graphql', graphqlHTTP({
  schema: schema,
  rootValue: resolvers,
  graphiql: true
}));


app.set('view engine', 'hbs');
app.set('views', path.join(__dirname, 'views'));

const hbs = require('handlebars');

hbs.registerHelper('formatDate', function (date) {
  return new Date(date).toISOString().split('T')[0];
});

hbs.registerHelper('eq', function (a, b) {
  return String(a) === String(b);
});

const methodOverride = require('method-override');
app.use(methodOverride('_method'));



const dbUser = process.env.DB_USER;
const dbPassword = process.env.DB_PASSWORD;
const dbURI = `mongodb+srv://${dbUser}:${dbPassword}@cluster0.uydfl.mongodb.net/`;

mongoose.connect(dbURI).then(() => {
  console.log('Connected to MongoDB');
}).catch(err => {
  console.error('Error connecting to MongoDB:', err);
});


app.get('/', (req, res) => res.render('index'));

app.get('/employees', async (req, res) => {
  const employees = await Employee.find();
  res.render('employees', { employees });
});

app.get('/items', async (req, res) => {
  const items = await Item.find();
  res.render('items', { items });
});

app.get('/issuances', async (req, res) => {
  const issuances = await Issuance.find().populate('employee_id').populate('item_id');
  res.render('issuances', { issuances });
});

app.post('/items', async (req, res) => {
  await Item.create(req.body);
  res.redirect('/items');
});

app.post('/employees', async (req, res) => {
  await Employee.create(req.body);
  res.redirect('/employees');
});

app.post('/issuances', async (req, res) => {
  await Issuance.create(req.body);
  res.redirect('/issuances');
});

app.put('/items/:id', async (req, res) => {
  await Item.findByIdAndUpdate(req.params.id, req.body);
  res.redirect('/items');
});

app.put('/employees/:id', async (req, res) => {
  await Employee.findByIdAndUpdate(req.params.id, req.body);
  res.redirect('/employees');
});

app.put('/issuances/:id', async (req, res) => {
  await Issuance.findByIdAndUpdate(req.params.id, req.body);
  res.redirect('/issuances');
});

app.delete('/employees/:id', async (req, res) => {
  await Issuance.deleteMany({ employee_id: req.params.id });
  await Employee.findByIdAndDelete(req.params.id);
  res.redirect('/employees');
});

app.delete('/items/:id', async (req, res) => {
  await Issuance.deleteMany({ item_id: req.params.id });
  await Item.findByIdAndDelete(req.params.id);
  res.redirect('/items');
});


app.delete('/issuances/:id', async (req, res) => {
  await Issuance.findByIdAndDelete(req.params.id);
  res.redirect('/issuances');
});



app.get('/add-item', (req, res) => {
  res.render('addItem');
});

app.get('/add-employee', (req, res) => {
  res.render('addEmployee');
});

app.get('/add-issuance', async (req, res) => {
  try {
    const employees = await Employee.find();
    const items = await Item.find();
    res.render('addIssuance', { employees, items });
  } catch (err) {
    console.error('Error fetching employees/items:', err);
    res.status(500).send('Internal Server Error');
  }
});


app.get('/edit-employee/:id', async (req, res) => {
  const employee = await Employee.findById(req.params.id);
  res.render('editEmployee', { employee });
});

app.get('/edit-item/:id', async (req, res) => {
  const item = await Item.findById(req.params.id);
  res.render('editItem', { item });
});


app.get('/edit-issuance/:id', async (req, res) => {
  const issuance = await Issuance.findById(req.params.id).populate('employee_id').populate('item_id');
  const employees = await Employee.find();
  const items = await Item.find();
  res.render('editIssuance', { issuance, employees, items });
});


app.get('/export/json', async (req, res) => {
  try {
    const employees = await Employee.find();
    const items = await Item.find();
    const issuances = await Issuance.find().populate('employee_id').populate('item_id');

    res.json({ employees, items, issuances });
  } catch (err) {
    console.error('Error fetching data:', err);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});


app.listen(3000, () => console.log('Server running on port 3000'));
