import { supabase } from '../supabase';
document.getElementById("search-button").addEventListener("click", searchEstudents, false);


function searchEstudents(e) {
    e.preventDefault();
    let inSearch = document.getElementById('input-search').value; 
    console.log(inSearch, 'data');


    let { data: students, error } = await supabase
      .from('students')
      .select('*')
      .eq('document', inSearch)
} 




function openModal() {
    console.log('op');
    var myModal = new bootstrap.Modal(
      document.getElementById("exampleModal")
    );
    myModal.show();
  }
  document.getElementById("openModal").addEventListener("click", openModal);