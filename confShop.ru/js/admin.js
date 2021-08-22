let selected = {
    'category': null,
    'action': null
}

updateForm = function() {
    let category = selected['category'];
    let action = selected['action'];
    if(category != null && action != null) {
        $('.admin-form').hide();
        $('#' + category + '-form-' + action).show()
    }
}

$( document ).ready(function() {
    $('.dropdown-item.choose-category-form').unbind("click").click(function () {
        $('#action-selector').show()
        selected['category'] = $(this).attr('form-criteria');
        updateForm()
    });

    $('.dropdown-item.choose-action-form').unbind("click").click(function () {
        selected['action'] = $(this).attr('form-action');
        updateForm()
    });
});