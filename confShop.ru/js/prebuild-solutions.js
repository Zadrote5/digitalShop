let componentArrayData = []
let searchCriteria = 'all';

compileMessageCard = function(message) {
    return '<div id="selector-case" class="card text-white bg-primary mb-3"><div class="row g-0"><div class="card-body"><p class="card-text">'+ message +'</p></div></div></div>'
};

compileCardTemplate = function(name, id, criteria, price, guid, description) {
    return '<div class="card text-white bg-primary mb-3" style="max-width: 540px;"> <div class="row g-0"> <div class="col-md-4"> <img src="' + config.apiUrl + '/img/' + guid + '" onerror="if (this.src != \'/images/' + criteria + '.svg\') this.src = \'/images/' + criteria + '.svg\';" class="card-img-top" alt="' + criteria + '"> </div><div class="col-md-8"> <div class="card-body"><span class="badge bg-secondary">' + (price / rate).toFixed(2) + ' ' + sign + '</span><p class="card-text">' + description +'</p></div></div></div></div>';
};

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
};

applySearchCriteria = function(searchCriteria) {
    $('#components-array').html(compileMessageCard('Searching components by criteria...'));
    $.getJSON( config.apiUrl + '/api/pc/read.php?gindex=' + searchCriteria).done(function (data) {
        componentArrayData = data;
        $('#components-array').html('');
        if (componentArrayData.message) {
            $('#components-array').append(compileMessageCard(componentArrayData.message));
            return false
        }
        for(let id in componentArrayData) {
            let component = componentArrayData[id];
            $('#components-array').append(compileCardTemplate(component.name, id, searchCriteria, component.price, component.guid, component.description))
        }
    })
}

$( document ).ready(function() {
    $('.dropdown-item.choose-currency').unbind("click").click(function () {
        let curr = $(this).attr('currency');
        currency = curr;
        localStorage.setItem('currency', curr);
        rate = config.rate[currency];
        sign = config.symbol[currency];
        applySearchCriteria(searchCriteria);
    });

    let currentSearchCriteria = getUrlParameter('gindex');
    if(currentSearchCriteria) searchCriteria = currentSearchCriteria;
    applySearchCriteria(searchCriteria);
    $('.dropdown-item.choose-search-criteria').unbind("click").click(function () {
        $('#select-category-button').html($(this).html());
        searchCriteria = $(this).attr('search-criteria');
        applySearchCriteria(searchCriteria)
    })
});




