import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L;