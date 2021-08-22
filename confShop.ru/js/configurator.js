let componentArrayData = []; // массив компонентов
let searchingTemplate = '<div>Пошук по критерії...</div>' // Карточка уведомления о поиске
let selectedSocket = null; // выбранный сокет
let timedOut = false; // вспомогательная переменная для подсказке о неполноте сборки
let selected = {
    'cpu': null,
    'fan': null,
    'motherboard': null,
    'gpu': null,
    'ram': null,
    'network': null,
    'drive': null,
    'ssd': null,
    'power': null,
    'case': null,
    'os': null,
}; // таблица выбранных элементов

let totalPrice = 0; // итоговая стоимость

updatePrice = function() {
    let sum = 0;
    for (let key in selected) {
        let pointer = selected[key];
        if(pointer != null && pointer.price != null) {
            sum += pointer.price / rate;
        }
    }
    totalPrice = sum.toFixed(2);
    $('#total-price').html(totalPrice + sign)
}; // метод для обновления итоговой стоимости

compileCardTemplate = function(name, id, criteria, price, guid, description) {
    return '<div class="card text-white bg-primary mb-3" style="max-width: 540px;"> <div class="row g-0"> <div class="col-md-4"> <img src="' + config.apiUrl + '/img/' + guid + '" onerror="if (this.src != \'/images/' + criteria + '.svg\') this.src = \'/images/' + criteria + '.svg\';" class="card-img-top" alt="' + criteria + '"> </div><div class="col-md-8"> <div class="card-body"> <h5 class="card-title">'+ name +'</h5><span class="badge bg-secondary">' + (price / rate).toFixed(2) + ' ' + sign + '</span><p class="card-text">' + description +'</p><button type="button" class="btn btn-success btn-add-to-config" data-bs-dismiss="modal" component-id="' + id + '" component-criteria="' + criteria + '"><i class="bi bi-plus-lg"></i></button></div></div></div></div>';
}; // метод для сборки карточки товара в предложенных вариантах

compileSelectedItemCardTemplate = function(name, id, criteria, price, guid, description) {
    return '<div class="card text-white bg-primary mb-3" style="max-width: 540px;"> <div class="row g-0"> <div class="col-md-4"> <img src="' + config.apiUrl + '/img/' + guid + '" onerror="if (this.src != \'/images/' + criteria + '.svg\') this.src = \'/images/' + criteria + '.svg\';" class="card-img-top" alt="' + criteria + '"> </div><div class="col-md-8"> <div class="card-body"> <h5 class="card-title">'+ name +'</h5><span class="badge bg-secondary">' + (price / rate).toFixed(2) + ' ' + sign + '</span><p class="card-text">' + description +'</p><button type="button" class="btn btn-danger btn-remove-from-config" data-bs-dismiss="modal" component-id="' + id + '" component-criteria="' + criteria + '"><i class="bi bi-dash"></i></button></div></div></div></div>'; // метод для сборки карточки товара на странице
};

compileListItem = function(name, guid, key) {
    return '<li class="list-group-item list-group-item-primary">' + name + ' <span class="badge bg-secondary">' + translation[key] + '</span><br /><span class="badge bg-primary">' + guid + '</span></li>'
}; // сборка элемента для компонента в итоговой сборке

clearAllComponents = function() {
    for (let key in selected) {
        clearComponent(key)
    }
}; // метод для очистки всех компонентов

clearComponent = function(criteria) {
    selected[criteria] = null;
    $('#selector-'+criteria).show(); // показ блока с категорией компонентов
    $('#item-'+criteria).html(''); // очистка блока компонента
    if ((criteria === 'cpu' || criteria === 'motherboard') && (selected['cpu'] == null && selected['motherboard'] == null)) {
        selectedSocket = null; // очистка сокета, если не осталось компонентов с сокетом
    }
    updatePrice() // обновление итоговой стоимости
}; // очистка одного компонента

compilePDF = function() {
    var doc = new jsPDF();
    doc.text('Your configuration', 10, 10);
    let rows = [];

    for (let key in selected) {
        let component = selected[key];
        if (component != null) {
            let row = [];
            let itemName = component['name'];
            let itemGUID = component['guid'];
            let itemType = translation[key];
            let itemPrice = (component['price'] / rate).toFixed(2);
            row.push(itemType);
            row.push(itemName);
            row.push(itemGUID);
            row.push(itemPrice);
            rows.push(row);
        }
    }
    rows.push(['Total Price', '', '', totalPrice]);

    doc.autoTable({
        head: [['Type', 'Name', 'Product ID', 'Price (' + currency + ')']],
        body: rows,
    });
    doc.save(Date.now() + '.pdf')
}; // метод сборки PDF, подробнее в документации библиотеки

proceedConfiguration = function() {
    if(!timedOut) {
        timedOut = true;
        let sum = 0; // счетчик незаполненных компонентов
        for (let key in selected) {
            let pointer = selected[key];
            if(pointer == null) {
                if(key === "os" || key === "network" || key === 'ssd') continue;
                sum += 1;
            }
        }
        if(sum > 0) {
            let alertBlock = $('#proceed-alert');
            alertBlock.show();
            setTimeout(function () {
                alertBlock.hide();
                timedOut = false;
            }, 3000)
        } // если что-то не заполнено, выводится уведомление на 3 секунды

        else {
            timedOut = false;
            let list = $('#pc-configured-array');
            list.html('')
            for (let key in selected) {
                let component = selected[key];
                if (component != null) {
                    let itemName = component['name'];
                    let itemGUID = component['guid'];
                    list.append(compileListItem(itemName, itemGUID, key));
                }
            }
            let myModal = new bootstrap.Modal(document.getElementById("configuredPC"), {});
            myModal.show(); // показ окна BootStrap

            $('.btn.btn-primary.btn-save-pdf').unbind("click").click(function () {
                compilePDF();
            }); // привязка метода к кнопке
        } // иначе показывается окно со сборкой
    }
} // метод завершения сборки ПК


$( document ).ready(function() {
    updatePrice(); // инициализация итоговой цены

    $('.dropdown-item.choose-currency').unbind("click").click(function () {
        let curr = $(this).attr('currency');
        currency = curr;
        localStorage.setItem('currency', curr);
        rate = config.rate[currency];
        sign = config.symbol[currency];
        clearAllComponents();
    }); // перепривязка смены валют

    $('.btn.btn-secondary.btn-proceed-configuration').unbind("click").click(function () {
        proceedConfiguration();
    });

    $('.btn.btn-danger.btn-clear-all').click(function () {
        clearAllComponents()
    }); // привязка очистки всех компонентов

    $('.btn.btn-success.btn-choose-to-config').unbind("click").click(function () {
        let componentCriteria = $(this).attr('component-criteria')
        $('#pc-config-array').html(searchingTemplate); // привязка выбора компонента к кнопке

        $.getJSON( config.apiUrl + '/api/product/read.php?category=' + componentCriteria).done(function (data) {
            componentArrayData = data; // получение массива компонентов от API
            $('#pc-config-array').html('');
            if (componentArrayData.message) {
                $('#pc-config-array').append(componentArrayData.message); // если получаем сообщение, вместо массива, то выводим его и останавливаемся
                return false
            }
            for(let id in componentArrayData) { // сборка карточек компонентов
                let component = componentArrayData[id];
                if(selectedSocket != null && (componentCriteria === 'cpu' || componentCriteria === 'motherboard')){
                    if(component.socket !== selectedSocket) continue
                }
                $('#pc-config-array').append(compileCardTemplate(component.name, id, componentCriteria, component.price, component.guid, component.description))
            }
            $('.btn.btn-success.btn-add-to-config').unbind("click").click(function () {
// привязка добавления компонента к кнопке
                selected[componentCriteria] = data[$(this).attr('component-id')];
                updatePrice();
                $('#selector-'+componentCriteria).hide();
                if(componentCriteria === 'cpu' || componentCriteria === 'motherboard'){
                    selectedSocket = selected[componentCriteria].socket;
                }
                let currentID = $(this).attr('component-id');
                let component = componentArrayData[currentID];
                $('#item-'+componentCriteria).html(compileSelectedItemCardTemplate(component.name, currentID, componentCriteria, component.price, component.guid, component.description))

                $('.btn.btn-danger.btn-remove-from-config').unbind("click").click(function () {
                    let criteria = $(this).attr('component-criteria');
                    clearComponent(criteria);
                })
            })
        })
    })

    var myModalEl = document.getElementById('selectComponent')
    myModalEl.addEventListener('hidden.bs.modal', function (event) {
        $('#pc-config-array').html(searchingTemplate);
    }) // очистка окна от компонентов
})
