const statusArraySelects = ['INITIAL', 'REGISTERED', 'CONNECTED', 'SELECTION', 'ALL_DOCUMENT'];
let userData = JSON.parse(localStorage.getItem('user'));



if (Object.keys(userData).length > 0) {
    document.getElementById("allname-selects").innerHTML = userData.allname;
    if (userData, statusArraySelects.indexOf(userData.register) == 0) {
        document.getElementById("asistenciasModal").addEventListener("click", AsistenciaModal);
        document.getElementById("card-p-registro").classList.add("text-dark");
    } else if(userData, statusArraySelects.indexOf(userData.register) == 1) {
        
        /**
         * Desactivar Asistencia
         */
        document.getElementById("card-p-asistencia").innerHTML = 'Registro de Asistencia Realizado';
        document.getElementById("card-image-asistencia").classList.add("disabled");
        document.getElementById("card-p-asistencia").classList.remove("text-danger");
        document.getElementById("card-p-asistencia").classList.add("text-dark");
        document.getElementById("asistenciasModal").classList.remove("btn-outline-danger");
        document.getElementById("asistenciasModal").classList.add("btn-outline-dark");
        document.getElementById("asistenciasModal").disabled = true;
        document.getElementById("card-h1-asistencia").innerHTML = 'Realizado';
       
        /**
         * Activar Registro
         */
         document.getElementById("card-button-registro").classList.remove("disabled");
         document.getElementById("card-button-registro").disabled = false;
         document.getElementById("card-image-registro").classList.remove("disabled");
    }

}


function AsistenciaModal() {
    var myModal = new bootstrap.Modal(
        document.getElementById("AsistenciaModal")
    );
    myModal.show();
}