function ckChange(ckType){
    // var ckName = document.getElementsByName(ckType.name);
    // var checked = document.getElementById(ckType.id);
    //
    // if (checked.checked) {
    //     for(var i=0; i < ckName.length; i++){
    //
    //         if(!ckName[i].checked){
    //             ckName[i].disabled = true;
    //         }else{
    //             ckName[i].disabled = false;
    //         }
    //     }
    // }
    // else {
    //     for(var i=0; i < ckName.length; i++){
    //         ckName[i].disabled = false;
    //     }
    // }

    if (document.getElementById('decision3').checked) {
        document.getElementById("consultation").style.display = 'contents';
    } else
        document.getElementById("consultation").style.display = 'none';

    if (document.getElementById('decision2').checked) {
        document.getElementById("type_intervention").style.display = 'contents';
    } else
        document.getElementById("type_intervention").style.display = 'none';

    if (document.getElementById('decision4').checked) {
        document.getElementById("type_acte").style.display = 'contents';
    } else
        document.getElementById("type_acte").style.display = 'none';

    if (document.getElementById('decision5').checked) {
        document.getElementById("anesthesiste").style.display = 'contents';
    } else
        document.getElementById("anesthesiste").style.display = 'none';
}


function myFunction() {
    if (!confirm("Veuillez confirmer la suppréssion"))
        event.preventDefault();
}

function searchFunction() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue

    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// $(document).ready(function(){
//     // Defining the local dataset
//     var cars = ['Audi', 'BMW', 'Bugatti', 'Ferrari', 'Ford', 'Lamborghini', 'Mercedes Benz', 'Porsche', 'Rolls-Royce', 'Volkswagen'];
//
//     // Constructing the suggestion engine
//     var cars = new Bloodhound({
//         datumTokenizer: Bloodhound.tokenizers.whitespace,
//         queryTokenizer: Bloodhound.tokenizers.whitespace,
//         local: cars
//     });
//
//     // Initializing the typeahead
//     $('.typeahead').typeahead({
//             hint: true,
//             highlight: true, /* Enable substring highlighting */
//             minLength: 1 /* Specify minimum characters required for showing result */
//         },
//         {
//             name: 'cars',
//             source: cars
//         });
// });

// $(document).ready(function(){
//     // Defining the local dataset
//     var path = "{{ route('autocomplete') }}";
//
//     $('.typeahead').typeahead(
//         {
//             source: function (query, process) {
//                 return $.get(path, { query: query}, function (data){
//                     return process(data);
//                 });
//             }
//         });
// });
