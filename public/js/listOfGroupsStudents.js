//Выборка для задания списка групп и студентов

$('#select_task_id').submit(function (e) {

    e.preventDefault();

    $.ajax({
        type: "POST",
        url: 'https://localhost/testovoe/index/updateListOfGroupsStudents',
        data: $(this).serializeArray(),
        success: function (response) {
            let jsonData = JSON.parse(response);
            if (jsonData.status == 'success') {
                console.log(jsonData);
                // console.log(jsonData.groups);

               renderTableContent(jsonData.students, jsonData.groups, jsonData.task);
            }

        },
        cache: false
    });

});

function renderTableContent(students, groups, task) {
    $(".table-container ").empty();
    let content = '<div><table class="table table-striped"><thead><tr><th scope="col">Задание</th><th scope="col">Студенты/группы</th></tr></thead><tbody>';
    
    students.forEach(student => {
        content += '<tr><td>' + task + '</td><td>' + student.first_name + ' '  + student.last_name  + '</td></tr>';
    });
    groups.forEach(group => {
        content += '<tr><td>' + task + '</td><td>' + group.id  + '</td></tr>';
    });

    
    content += '</tbody></table></div>';
    $(".table-container ").append(content);
}
