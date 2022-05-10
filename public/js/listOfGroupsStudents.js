//Выборка для задания списка групп и студентов

$('#select_task_id').submit(function (e) {

    e.preventDefault();

    $.ajax({
        type: "POST",
        url: 'https://localhost/testovoe/index/updateListOfGroupsStudents',
        data: $(this).serializeArray(),
        success: function (response) {
            console.log(response);
            let jsonData = JSON.parse(response);
            if (jsonData.status == 'success') {
                console.log(jsonData);
                // console.log(jsonData.groups);

               renderTableContent(jsonData.taskStudents, jsonData.task);
            }

        },
        cache: false
    });

});

function renderTableContent(taskStudents, task) {
    $(".table-container ").empty();
    let content = '<div><table class="table table-striped"><thead><tr><th scope="col">Задание</th><th scope="col">Студенты/группы</th></tr></thead><tbody>';
    
    taskStudents.forEach(student => {
        student.groups.forEach(group =>{
            content += '<tr><td>' + task + '</td><td>' + student.firstName + ' '  + student.lastName  + '</td><td>'+ group.id +'</td></tr>';
        });
       // 
    });
   

    
    content += '</tbody></table></div>';
    $(".table-container ").append(content);
}
