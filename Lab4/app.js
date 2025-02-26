const express = require('express');
const { engine } = require('express-handlebars');
const path = require('path');
const axios = require('axios');
const hbs = require('hbs');
require('dotenv').config();

const app = express();
const PORT = 3000;
const API_KEY = process.env.OPENWEATHER_API_KEY;
const IP_API_KEY = process.env.IPAPI_API_KEY;
const DEFAULT_CITIES = ['Kyiv', 'Lviv', 'Odesa', 'Dnipro', 'Kharkiv', 'Chisinau'];
const AUTHOR_LOCATION = 'Varnita';


app.engine('hbs', engine({
  extname: 'hbs',
  defaultLayout: 'main',
  layoutsDir: path.join(__dirname, 'views/layouts'),
  partialsDir: path.join(__dirname, 'views/partials'),
}));
app.set('view engine', 'hbs');
app.set('views', path.join(__dirname, 'views'));

hbs.registerPartials(path.join(__dirname, 'views/partials'));
app.use(express.static(path.join(__dirname, 'public')));

async function getWeather(city) {
  try {
    const response = await axios.get(`https://api.openweathermap.org/data/2.5/weather`, {
      params: {
        q: city,
        appid: API_KEY,
        units: 'metric',
        lang: 'uk'
      }
    });
    return response.data;
  } catch (error) {
    return null;
  }
}

app.get('/', (req, res) => {
  res.render('index', { cities: [...DEFAULT_CITIES, AUTHOR_LOCATION] });
});

app.get('/weather/:city', async (req, res) => {
  const city = req.params.city;
  const weatherData = await getWeather(city);

  if (!weatherData) {
    return res.render('error', { message: `Не вдалося отримати дані про погоду для ${city}`, cities: [...DEFAULT_CITIES, AUTHOR_LOCATION] });
  }

  res.render('weather', {
    city: weatherData.name,
    temp: weatherData.main.temp,
    description: weatherData.weather[0].description,
    icon: `https://openweathermap.org/img/wn/${weatherData.weather[0].icon}.png`,
    cities: [...DEFAULT_CITIES, AUTHOR_LOCATION]
  });
});

app.get('/weather', async (req, res) => {
  const ip = req.headers['x-forwarded-for'] || req.socket.remoteAddress;
  let default_city = 'Kyiv';

  try {
    if (ip !== '127.0.0.1' && ip !== '::1') {
      const locationRes = await axios.get(`https://ip-api.com/json/${ip}`);
      default_city = locationRes.data.city || default_city;
    } else {
      const ipRes = await axios.get('https://ifconfig.me/ip');
      const realIp = ipRes.data.trim();

      const locationRes = await axios.get(`https://ipinfo.io/${realIp}/json?token=${IP_API_KEY}`);
      default_city = locationRes.data.city || 'Kyiv';
    }


    return res.redirect(`/weather/${default_city}`);
  } catch (error) {
    return res.render('error', { message: 'Не вдалося визначити ваше місцезнаходження', cities: [...DEFAULT_CITIES, AUTHOR_LOCATION] });
  }
});


app.listen(PORT, () => {
  console.log(`Сервер запущено на http://localhost:${PORT}`);
});
