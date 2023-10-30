const statusArray = ['INITIAL', 'REGISTERED', 'CONNECTED', 'SELECTION', 'ALL_DOCUMENT'];
let userDataInsert = JSON.parse(localStorage.getItem('user'));
const hostFinal = "http://localhost:8000";
const urlFinal = `${hostFinal}/api/students/${userDataInsert.uuid}/asistencia`


let email = document.getElementById("email").value = userDataInsert.email;
let phone = document.getElementById("phone").value = userDataInsert.phone;
let phone_attendant = document.getElementById("phone_attendant").value = userDataInsert.phone_attendant;


document.getElementById("btn-register-in-asistencia").addEventListener("click", enviarAsistencia);

// esta funcion actualiza o inserta un usuario
async function enviarAsistencia(e) {
  e.preventDefault();

  let email = document.getElementById("email").value;
  let phone = document.getElementById("phone").value;
  let phone_attendant = document.getElementById("phone_attendant").value;
  let accept = document.querySelector(".checkbox").checked;

  // Si User existe no es necesario modificar datos
  let final = { email, phone, phone_attendant };
  console.log(final, 'final');
  let listValidations = [];
  Object.keys(final).forEach((el, index) => {
    Object.values(final).forEach((val, idx) => {
      if (index == idx) {
        document.getElementById(`error-${el}`).innerText = '';
        if (validations(val, el) != null) {
          document.getElementById(`error-${el}`).innerText = validations(val, el)[0];
          if (validations(val, el)[1]) {
            listValidations.push(true);
          }
        }
      }
    });
  });


  if (checkedVal(accept) == false) {
    listValidations.push(true);
  }


  if (listValidations.length == 0) {
    const requestOptions = {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        phone,
        phone_attendant,
        email,
        accept,
      })
    };

    await fetch(urlFinal, requestOptions).then((response) => {
      console.log(response);
      if (response.ok) {
        console.log(sendObjFinal, 'se envio');
        return response.json();
      }
      // throw new Error('A ocurrido un error en la consulta');
    }).catch((error) => {
      console.log(error)
    });

  }
}


function validations(data, el) {
  if (data == null) {
    return ['Este campo es requerido', true];
  }

  if (data == '') {
    return ['Este campo es requerido', true];
  }

  if (el == 'email') {
    if (!validator.isEmail(data)) {
      return ['El campo no se reconoce correctamente como un Email', true]
    }
  }

  const vals = ['name', 'last'];
  if (vals.includes(el)) {
    if (!validator.isAlpha(data, 'es-ES', { 'ignore': " " })) {
      return ['El campo no se reconoce correctamente como un Texto A-Z', true]
    }
  }

  const nums = ['phone', 'phone_attendant'];
  if (nums.includes(el)) {
    if (!validator.isInt(data, { min: 3000000000, max: 9999999999 })) {
      return ['El campo no se reconoce correctamente como un Número Celular', true]
    }
  }
  return null;

}

function checkedVal(accept) {
  document.getElementById(`error-accept`).innerText = '';
  if (accept == false) {
    document.getElementById(`error-accept`).innerText = 'Este campo debe ser Aceptado';
    return false;
  } else {
    return null;
  }
}