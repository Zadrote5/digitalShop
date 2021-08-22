let pcArrayData = []
let componentsTable = {};
let searchCriteria = 'all';

compileListItem = function(name, key) {
    return '<li class="list-group-item list-group-item-primary">' + name + ' <span class="badge bg-secondary">' + translation[key] + '</span></li>'
};

compileMessageCard = function(message) {
    return '<div id="selector-case" class="card text-white bg-primary mb-3"><div class="row g-0"><div class="card-body"><p class="card-text">'+ message +'</p></div></div></div>'
};

compileCardTemplate = function(name, id, criteria, price, guid, description) {
    return '<div id="' + guid + '" class="card text-white bg-primary mb-3" style="max-width: 540px;"> <div class="row g-0"> <div class="col-md-4"> <img src="' + config.apiUrl + '/img/' + guid + '" onerror="this.onerror=null; this.src = \'/images/unknown.svg\';" class="card-img-top" alt="' + criteria + '"> </div><div class="col-md-8"> <div class="card-body"><span class="badge bg-secondary">' + (price / rate).toFixed(2) + ' ' + sign + '</span><p class="card-text">' + description +'</p><div class="order-items-row"><button id="show-pc-' + guid + '-components" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Components</button><ul class="dropdown-menu" id="pc-' + guid + '-components-array"></ul></div></div></div></div></div>';
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
        pcArrayData = data;
        $('#components-array').html('');
        if (pcArrayData.message) {
            $('#components-array').append(compileMessageCard(pcArrayData.message));
            return false
        }
        for(let id in pcArrayData) {
            let pc = pcArrayData[id];
            componentsTable[pc.guid] = pc;
            $('#components-array').append(compileCardTemplate(pc.name, id, pc.category, pc.price, pc.guid, pc.description))
            let list = $('#pc-'+ pc.guid +'-components-array');
            for (let key in pc) {
                let component = pc[key];
                if (component != null && !bannedKeys.includes(key)) {
                    let componentName = component
                    list.append(compileListItem(componentName, key));
                }
            }
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




