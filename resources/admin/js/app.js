import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

require('./_functions');
require('./alpineModules');

Alpine.start();
