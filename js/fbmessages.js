function getFBMessages(page) {
    var x = $.ajax({
        type: 'POST',
        url: '../../php/ajaxdata.php',
        async: false,
        data: {
            fill: 'get_fb_messages',
            page: page},
        dataType: "json",
        success: function(data) {
            var parent  = document.getElementById("allfbmtbody");
            var markBtnIsEmpty = true;
            
            // Если запрашиваемая страница первая, то нужно очистить таблицу, иначе -- дополнить снизу
            var moreBtn = document.getElementById('morebtn');
            if (page == 1) {
                parent.innerHTML = '';
                moreBtn.setAttribute('value', 2);
            } else {
                var nextPage = parseInt(document.getElementById('morebtn').getAttribute('value'), 10) + 1;
                moreBtn.setAttribute('value', nextPage);
            }
            
            data.forEach(function(element) {
                if (markBtnIsEmpty) {
                    document.getElementById('markallbtn').onclick = function() {
                        mark('marks', element.id);
                    };
                    markBtnIsEmpty = false;
                }
                
                // Заполнение таблицы сообщений полученными данными, построчно
                newNode =
                `<tr>
                    <td><input id="` + element.id + '" type="checkbox" name="marks" value="' + element.id + '">' + element.n + `
                    <td>` + element.instr +  `
                    <td>
                    <td>` + element.date + `
                    <td>` + element.data + `
                    <td>` + element.status +  `
                </tr>`;
                parent.insertAdjacentHTML("beforeend", newNode);
            });
            checkMoreNotes();
        }
    }).responseText;
}
function getMoreNotes() {
    getFBMessages(document.getElementById('morebtn').getAttribute('value'));
}
// Проверка существования следующих записей: если "Получать ещё" нечего, то скрыть соответствующую кнопку
function checkMoreNotes() {
    var x = $.ajax({
        type: 'POST',
        url: '../../php/ajaxdata.php',
        async: false,
        data: {
            action:     'check_fb_messages',
            page:       document.getElementById('morebtn').getAttribute('value')},
        dataType: "json",
        success: function(notesExist) {
            if (!notesExist) {
                hideElem('morebtn');
            }
        }
    }).responseText;
}
function getDeleteConfirmation() {
    var answer = confirm("Удалить выбранные сообщения?\nОтменить это действие будет невозможно.");
    if (answer) {
        deletingFBMessages = getMarkedElements('marks');
        
        // Отправка на сервер для удаления
        if (deletingFBMessages !== []) {
            var x = $.ajax({
                type: 'POST',
                url: '../../php/ajaxdata.php',
                async: false,
                data: {
                    action: 'delete_fb_messages',
                    fbmes:  JSON.stringify(deletingFBMessages)},
                dataType: "json",
                success: function(data) {
                    location.reload();
                }
            });
        }
    }
}
function getChangeStatusConfirmation() {
    var answer = confirm("Сменить статус выбранных сообщений?");
    if (answer) {
        changingFBMessages = getMarkedElements('marks');
        
        // Отправка на сервер для изменения статуса
        if (changingFBMessages !== []) {
            var x = $.ajax({
                type: 'POST',
                url: '../../php/ajaxdata.php',
                async: false,
                data: {
                    action: 'change_status_fb_messages',
                    fbmes:  JSON.stringify(changingFBMessages)},
                dataType: "json",
                success: function(data) {
                    location.reload();
                }
            });
        }
    }
}