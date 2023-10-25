document.getElementById("btn-send-in-modal").addEventListener("click", sending);
const statusArray = ['INITIAL', 'REGISTERED', 'CONNECTED', 'SELECTION', 'ALL_DOCUMENT'];


function sending(e) {
  var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
  debugger;
  if (e.target.dataset["send"] == "/close") {
    myModal.hide();
  }
  if (e.target.dataset["send"] == "/selects") {
    localStorage.setItem('user', JSON.stringify({}));
    window.location.href = e.target.dataset["send"];
  } else {
    window.location.href = e.target.dataset["send"];
  }
}

