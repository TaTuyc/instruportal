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
        }
    }).responseText;
}
function getMoreNotes() {
    getFBMessages(document.getElementById('morebtn').getAttribute('value'));
}