import './bootstrap';
import '../css/app.css';

// Import fonts
import '@fontsource/righteous';
import '@fontsource/montserrat/400.css';
import '@fontsource/montserrat/500.css';
import '@fontsource/montserrat/600.css';
import '@fontsource/montserrat/700.css';

// Import Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// We'll use the CDN approach instead of importing from node_modules