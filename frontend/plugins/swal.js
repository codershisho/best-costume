import Swal from 'sweetalert2';

export default defineNuxtPlugin((nuxtApp) => {
  const showAlert = (status, title = '', message) => {
    const swalConfig = {
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
    };

    if (status === 'success') {
      Swal.fire({
        ...swalConfig,
        title: title != '' ? title : 'Success!',
        text: message,
        icon: 'success',
        timer: 3000,
      });
    } else if (status === 'error') {
      Swal.fire({
        ...swalConfig,
        title: title != '' ? title : 'Error!',
        text: message,
        icon: 'error',
        timer: 5000,
        background: '#AF2655',
        color: '#F3EEEA',
      });
    } else if (status === 'warning') {
      Swal.fire({
        ...swalConfig,
        title: title != '' ? title : 'Warning!',
        text: message,
        icon: 'warning',
        timer: 5000,
        background: '#FCFFB2',
        color: '#EC8F5E',
      });
    }
  };
  nuxtApp.provide('showAlert', showAlert);
});
