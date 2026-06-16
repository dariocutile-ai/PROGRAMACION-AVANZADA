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

// Add login-page class to body on login page
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.login-page')) {
        document.body.classList.add('login-page');
    }

    // Replace JavaScript confirm with SweetAlert2 for delete forms
    const deleteForms = document.querySelectorAll('form[data-confirm]');
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = form.getAttribute('data-confirm') || '¿Estás seguro?';
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#DA3633',
                cancelButtonColor: '#30363D'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Replace inline onsubmit confirm with SweetAlert2
    const formsWithConfirm = document.querySelectorAll('form[onsubmit]');
    formsWithConfirm.forEach(function(form) {
        const onsubmitAttr = form.getAttribute('onsubmit');
        if (onsubmitAttr && onsubmitAttr.includes('return confirm(')) {
            form.removeAttribute('onsubmit');
            const message = onsubmitAttr.match(/'([^']+)'/)[1];
            form.setAttribute('data-confirm', message);
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#DA3633',
                    cancelButtonColor: '#30363D'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    });

    // Display success alerts with SweetAlert2
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        const message = successAlert.textContent.trim();
        Swal.fire({
            title: '¡Éxito!',
            text: message,
            icon: 'success',
            timer: 3000,
            showConfirmButton: false,
            background: '#161B22',
            color: '#F0F6FC'
        });
        successAlert.style.display = 'none';
    }
});
