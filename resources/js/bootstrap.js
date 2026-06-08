import axios from 'axios';
import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.css';

window.axios = axios;
window.Swal = Swal;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Global SweetAlert2 configuration
Swal.mixin({
    customClass: {
        popup: 'github-dark-modal',
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-secondary',
        denyButton: 'btn btn-danger'
    },
    buttonsStyling: true,
    background: '#161B22',
    color: '#F0F6FC',
    confirmButtonColor: '#238636',
    cancelButtonColor: '#30363D',
    denyButtonColor: '#DA3633'
});
