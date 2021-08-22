let componentArrayData = [];
let componentsTable = {};
let searchCriteria = 'all';

compileMessageCard = function(message) {
    return '<div id="selector-case" class="card text-white bg-primary mb-3"><div class="row g-0"><div class="card-body"><p class="card-text">'+ message +'</p></div></div></div>'
}; // сборка карточки поиска

compileCardTemplate = function(name, id, criteria, price, guid, description) {
    return '<div id="' + guid + '" class="card text-white bg-primary mb-3" style="max-width: 540px;"> <div class="row g-0"> <div class="col-md-4"> <img src="' + config.apiUrl + '/img/' + guid + '" onerror="this.onerror=null; this.src = \'/images/unknown.svg\';" class="card-img-top" alt="' + criteria + '"> </div><div class="col-md-8"> <div class="card-body"> <h5 class="card-title">'+ name +'</h5><span class="badge bg-secondary">' + (price / rate).toFixed(2) + ' ' + sign + '</span><p class="card-text">' + description +'</p><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#alertModal" type="button" class="btn btn-danger btn-remove-component" component-guid="' + guid + '"><i class="bi bi-dash"></i></a></div></div></div></div>';
}; // сборка карточки товара

getUrlParameter = function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
}; // метод получения GET параметров из URL

applySearchCriteria = function(searchCriteria) {
    $('#components-array').html(compileMessageCard('Searching components by criteria...'));
    $.getJSON( config.apiUrl + '/api/product/read.php?category=' + searchCriteria).done(function (data) {
        componentArrayData = data;
        $('#components-array').html('');
        if (componentArrayData.message) {
            $('#components-array').append(compileMessageCard(componentArrayData.message));
            return false
        }
        for(let id in componentArrayData) {
            let component = componentArrayData[id];
            componentsTable[component.guid] = component;
            $('#components-array').append(compileCardTemplate(component.name, id, component.category, component.price, component.guid, component.description))
        }
        $('.btn.btn-danger.btn-remove-component').unbind('click').click(function () {
            currGUID = $(this).attr('component-guid');

            $('.btn.btn-danger.btn-delete-confirm').unbind('click').click(function () {
                $('#' + currGUID).hide();
                $.post( config.apiUrl + "/api/product/delete.php", JSON.stringify( {guid: currGUID} ) )
            })
        })
    })
}; // метод применения критерии поиска

onSuccessAdd = function() {
    var myModalEl = document.getElementById('addComponentModal')
    var addModal = bootstrap.Modal.getInstance(myModalEl)
    addModal.hide();
    $("#products-form-create :input").prop("disabled", false);
    applySearchCriteria(searchCriteria);
    $('#products-form-create')[0].reset();
}; // метод обработки удачной отправки запроса

onErrorAdd = function() {
    $("#products-form-create :input").prop("disabled", false);
}; // метод обработки неудачной отправки запроса

$( document ).ready(function() {

    $("#products-form-create").validate({
        rules:{
            name:{
                required: true,
            },
            socket:{
                required: true,
            },
            category:{
                required: true,
            },
            price:{
                required: true,
            },
            myimage:{
                required: true,
            }
        }
    }); // валидация форм jquery-validate

    $(".btn.btn-primary.btn-submit-form").on("click", function(e) {

        var form = $("#products-form-create");

        var formData = new FormData(form[0]);

        if ($("#products-form-create").valid()) { // проверка формы на валидность
            $("#products-form-create :input").prop("disabled", true); // отключение полей для ввода
            $.ajax({
                type: "POST",
                url: config.apiUrl + "/api/product/create.php", // привязка URL из конфигурации
                data: formData,
                contentType: false,
                processData: false,
            }).then(function() {
                onSuccessAdd();
            }).catch(function() {
                onErrorAdd();
            });

        }
    }); // отправка формы

    $('.dropdown-item.choose-currency').unbind("click").click(function () {
        let curr = $(this).attr('currency');
        currency = curr;
        localStorage.setItem('currency', curr);
        rate = config.rate[currency];
        sign = config.symbol[currency];
        applySearchCriteria(searchCriteria);
    });

    let currentSearchCriteria = getUrlParameter('category');
    if(currentSearchCriteria) searchCriteria = currentSearchCriteria;
    applySearchCriteria(searchCriteria);
    $('.dropdown-item.choose-search-criteria').unbind("click").click(function () {
        $('#select-category-button').html($(this).html());
        searchCriteria = $(this).attr('search-criteria');
        applySearchCriteria(searchCriteria)
    }) // выбор критерии поиска
});
