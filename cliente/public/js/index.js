document.getElementById("search-button").addEventListener("click", searchEstudents, false);
const urlParams = new URLSearchParams(window.location.search);
const urlFinal = "http://localhost:8000"
localStorage.setItem('ms', urlParams.get('ms'));

async function searchEstudents(e) {
  e.preventDefault();
  let inSearch = document.getElementById('input-search').value;

  let valInSearch = validator.isNumeric(inSearch, { no_symbols: true });

  if (valInSearch) {
    const response = await fetch(`${urlFinal}/api/search/${inSearch}`);
    const students = await response.json();
    if (students.type == 'error') {
      var myModal = new bootstrap.Modal(
        document.getElementById("exampleModal")
      );
      myModal.show();
      document.getElementById("openModal").addEventListener("click", openModal);
    } else if (students.type == 'ok') {
      localStorage.setItem('user', JSON.stringify(students.data));
      window.location.href = '/selects';
    }
  }

}


function openModal() {
  var myModal = new bootstrap.Modal(
    document.getElementById("exampleModal")
  );
  myModal.show();
}
document.getElementById("openModal").addEventListener("click", openModal);


