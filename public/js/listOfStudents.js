// LIST OF STUDENTS

$('#select_lesson_id').submit(function (e) {

    e.preventDefault();
  
    $.ajax({
        type: "POST",
        url: 'https://localhost/testovoe/index/updateListOfStudents',
        data: $(this).serializeArray(),
        success: function (response) {
            let jsonData = JSON.parse(response);
            if (jsonData.status == 'success') {
                console.log(jsonData.data);
               renderTableContent(jsonData.data);
            }

        },
        cache: false
    });

});

function renderTableContent(data) {
    $(".table-container ").empty();
    let content = '<div><table class="table table-striped"><thead><tr><th scope="col">Имя</th><th scope="col">Фамилия</th></tr></thead><tbody>';
    data.forEach(student => {
       
            content += '<tr>';
        content += '<td>' + student.first_name + '</td><td>' + student.last_name + '</td>';
    });
    content += '</tbody></table></div>';
    $(".table-container ").append(content);
}