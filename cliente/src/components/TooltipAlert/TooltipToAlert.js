
let item = document.getElementsByClassName('hidden').length > 0;
let msStorage = localStorage.getItem('ms');

function acInItem(msStorage, paramName, paramText) {
    if (msStorage == paramText) {
        if (item) {
            let urlParams = new URLSearchParams(window.location.search);
            urlParams.delete(paramName);
            localStorage.removeItem(paramName)
            document.getElementById('to-alert').classList.remove('hidden');
        }
    }
}

// Aqui se añadiría en geral cualquier tipo de item 
acInItem(msStorage, 'ms', 'insert-error'); 

setTimeout(() => {
    document.getElementById('to-alert').classList.add('hidden');
}, 8000);

document.getElementById('btn-alert').addEventListener('click', (e) => {
    let item = document.getElementsByClassName('hidden').length > 0;
    e.preventDefault();
    if (item) {
        document.getElementById('to-alert').classList.remove('hidden');
    } else {
        window.location.href = '/';
    }
})
