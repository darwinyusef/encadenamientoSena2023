document.getElementById("btn-asistencia-in-modal").addEventListener("click", asistenciaBtn);

const statusArray = ['INITIAL', 'REGISTERED', 'CONNECTED', 'SELECTION', 'ALL_DOCUMENT'];

function asistenciaBtn(e) {
  e.preventDefault();
  let userData = JSON.parse(localStorage.getItem('user') ).register;

  console.log(userData, statusArray.indexOf(userData) == 1 ); 
}