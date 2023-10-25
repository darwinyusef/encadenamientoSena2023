
const status = [ 'INITIAL','CONNECTED','SELECTION','REGISTERED','ALL_DOCUMENT'];

let objUser = JSON.parse(localStorage.getItem('user'));

// si no existe el usuario lo reguresa a index/
if (objUser == null) {
    window.location.href = '/?ms=insert-error'
}

console.log(Object.keys(objUser).length);

// Elimina el titulo si hay un registro de 0
if (Object.keys(objUser).length == 0) {
    document.getElementById("hiddenTitle").classList.add("hidden");
}

// Oculta inputs y asigna un nombre si existe un usuario ya registrado
if (Object.keys(objUser).length > 0) {
    document.getElementById("hidden1").remove();
    document.getElementById("hidden2").remove();
    document.getElementById("hidden3").remove();
    document.getElementById("all-name").innerText = `${objUser.allname}`

}

// esta funcion actualiza o inserta un usuario
document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    let name = document.getElementById("name").value;
    let last = document.getElementById("last").value;
    let omeDocument = document.getElementById("omeDocument").value;
    let typedocument = (
        document.getElementById("typedocument")).value;
    let phone = document.getElementById("phone").value;
    let phone_attendant = document.getElementById("phone_attendant").value;
    let email = document.getElementById("email").value;
    let ie = document.getElementById("ie").value;
    let accept = document.querySelector(".checkbox").checked;

    // Si User existe no es necesario modificar datos
    if (objUser.actual_status == status[0] &&
        objUser.ie == null &&
        objUser.accept == null &&
        objUser.phone == null &&
        objUser.phone_attendant == null) {
        name = objUser.name;
        last = objUser.last;
        omeDocument = objUser.document;
        typedocument = objUser.typedocument;
    }

    let final = {
        name,
        last,
        phone,
        phone_attendant,
        email,
        omeDocument,
        typedocument,
        ie,
    };


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

    console.log(final, listValidations, 'final');
    if (listValidations.length == 0) {
        if (objUser.register == false,
            objUser.actual_status == status[0] &&
            objUser.document != null) {
            let sendObjFinal = {
                phone,
                phone_attendant,
                email,
                document: omeDocument,
                typedocument,
                ie,
                accept,
                created_at: String(finalDate),
                update_at: String(finalDate),
                register: true
            }


            if (Object.keys(objUser).length == 0) {
                sendObjFinal.name = final.name;
                sendObjFinal.last = final.last;
                sendObjFinal.document = final.omeDocument;
                sendObjFinal.typedocument = final.typedocument;
                sendObjFinal.actual_status = status[1];
                sendObjFinal.register = true;
                console.log(sendObjFinal);

                // let { students, error } = await supabase.from('students')
                // .insert(sendObjFinal)
                //     .select()
            }
            if (Object.keys(objUser).length > 0) {
                sendObjFinal.actual_status = status[1];
                sendObjFinal.register = true;
                console.log(sendObjFinal);

                // let { students, error } = await supabase.from('students')
                //     .update(sendObjFinal)
                //     .eq('document', final.omeDocument)
                //     .select()
            }
           // console.log(error);
            if (await error != null) {
                alert(await error);
            }
        }
    }
});

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