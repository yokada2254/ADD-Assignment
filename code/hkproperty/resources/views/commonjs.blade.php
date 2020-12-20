window._package_statuses = {!! $package_statuses !!};
window._transaction_types = {!! $transaction_types !!};
window._property_options = {!! $property_options !!};
window.__ = function(key){
    let translations = {!! $translations !!};
    return translations[key] ?? key;
}

window._branches = {!! $branches !!};
window._users = {!! $users !!};
window._customer_statuses = {!! $customer_statuses !!};