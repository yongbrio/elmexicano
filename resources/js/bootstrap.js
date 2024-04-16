import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Sweetalert2 Import
import Swal from 'sweetalert2'
window.Swal = Swal;

import Datepicker from 'flowbite-datepicker/Datepicker';
window.Datepicker = Datepicker;
