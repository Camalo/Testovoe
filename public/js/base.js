// INDEX

$('#select_student_id').submit(function (e) {

    e.preventDefault();

    $.ajax({
        type: "POST",
        url: 'https://localhost/testovoe/index/updateTaskOfStudent',
        data: $(this).serializeArray(),
        success: function (response) {
            let jsonData = JSON.parse(response);
            if (jsonData.status == 'success') {
                renderTableContent(jsonData.data);
            }

        },
        cache: false
    });

});

function renderTableContent(data) {
    $(".table-container ").empty();
    let content = '<div><table class="table table-striped"><thead><tr><th scope="col">Задание</th><th scope="col">Проверено/непроверено</th></tr></thead><tbody>';
    data.forEach(task => {
        if (task.status == 'unchecked')
            content += '<tr class="table-danger">';
        else
            content += '<tr>';
        content += '<td>' + task.task + '</td><td>' + task.status + '</td>';
    });
    content += '</tbody></table></div>';
    $(".table-container ").append(content);
}



