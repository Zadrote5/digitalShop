if(localStorage.getItem('currency') == null) localStorage.setItem('currency', 'UAH'); // установка валюты по умолчанию в хранилище браузера, RUB - рубли, USD - доллары, UAH - гривны

let config = {
    'apiUrl': '', // URL api – нужно, если Backend разделен от Frontend’а, пустая строка – если не разделен.

    'rate': {
        'RUB' : 1,
        'USD' : 73.55,
        'UAH' : 2.67
    }, // курс валют, указывается вручную.

    'symbol' : {
        'RUB' : '₽',
        'USD' : '$',
        'UAH' : '₴'
    } // перевод кода валюты в знак.
};

let translation = {
    'cpu': 'CPU',
    'fan': 'Fan',
    'motherboard': 'Motherboard',
    'gpu': 'GPU',
    'ram': 'RAM',
    'network': 'Network Card',
    'drive': 'Hard Drive',
    'ssd': 'Solid State Drive',
    'power': 'Power Supply',
    'case': 'Case',
    'pccase': 'Case',
    'os': 'OS',
    'gindex': 'Purpose'
};  // перевод категории комплектующих/пк в текст

let bannedKeys = ['id', 'guid', 'description', 'price'] // отсеивание ключей для скрытия комплектующих на странице готовых решений
let recommendedCriterias = ['mouse', 'display', 'keyboard', 'headset'] // выборка критерий, где покажется рекомендация в каталоге

let currency = localStorage.getItem('currency'); // установка валюты из хранилища браузера
let rate = config.rate[currency]; // установка курса валют
let sign = config.symbol[currency]; // установка знака валют

$( document ).ready(function() {
    $('.dropdown-item.choose-currency').unbind("click").click(function () { // кнопка для смены валюты
        let curr = $(this).attr('currency'); // получение значения из аттрибута кнопки “currency”
        currency = curr;
        localStorage.setItem('currency', curr); // установка валюты глобально
        rate = config.rate[currency];
        sign = config.symbol[currency]; // обновление знаков и курса валют
    });
});
