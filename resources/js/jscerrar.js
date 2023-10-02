function fntcerrar() {
  Swal.fire({
    title: "¿Deseas cerrar sesión?",
    text: "Se cerrará la sesión actual",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    dangerMode: true,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "Login/logout"; // Redireccionar al archivo que cierra sesión
    } else {
      Swal.close(); // Cerrar SweetAlert
    }
  });
}
