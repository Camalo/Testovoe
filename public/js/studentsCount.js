// studentsCount

$('#select_task_id').submit(function (e) {

    e.preventDefault();

    $.ajax({
        type: "POST",
        url: 'https://localhost/testovoe/Index/updateStudentsCount',
        data: $(this).serializeArray(),
        success: function (response) {
            console.log(response);
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
    let content = '<div><table class="table table-striped"><thead><tr><th scope="col">Задание</th><th scope="col">Количество студентов</th></tr></thead><tbody><tr><td>';
    content += data.taskId + '</td><td>' + data.count + '</td></tr>';
    content += '</tbody></table></div>';
    $(".table-container ").append(content);
}