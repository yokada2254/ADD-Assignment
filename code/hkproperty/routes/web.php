<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/commonjs', function(){
    return response()
        ->view('commonjs')
        ->header('Content-Type', 'application/javascript')
        ->header('Cache-Control', 'max-age=3600');
})->name('common.js');

Route::middleware(['auth'])->group(function(){
    Route::prefix('branch')->group(function(){
        Route::get('', 'BranchController@index')->name('branch.index');
        Route::get('{branch}/edit', 'BranchController@edit')->name('branch.edit');
        Route::patch('{branch}', 'BranchController@update')->name('branch.update');
    });

    Route::prefix('role')->group(function(){
        Route::get('', 'RoleController@index')->name('role.index');
        Route::get('create', 'RoleController@create')->name('role.create');
        Route::post('store', 'RoleController@store')->name('role.store');
        Route::get('{role}', 'RoleController@show')->name('role.show');
        Route::get('{role}/edit', 'RoleController@edit')->name('role.edit');
        Route::patch('{role}', 'RoleController@update')->name('role.update');
    });

    Route::prefix('user')->group(function(){
        Route::get('', 'UserController@index')->name('user.index');
        Route::get('{user}/edit', 'UserController@edit')->name('user.edit');
        Route::patch('{user}', 'UserController@update')->name('user.update');
    });

    Route::prefix('people')->group(function(){
        Route::get('', 'PeopleController@index')->name('people.index');
        Route::get('create', 'PeopleController@create')->name('people.create');
        Route::get('{people}', 'PeopleController@show')->name('people.show');
        Route::post('', 'PeopleController@store')->name('people.store');
        Route::get('{people}/edit', 'PeopleController@edit')->name('people.edit');
        Route::patch('{people}', 'PeopleController@update')->name('people.update');
        Route::delete('{people}', 'PeopleController@store')->name('people.destroy');

        Route::get('{people}/contact', 'PeopleContactController@index')->name('people.contact.index');
        Route::get('{people}/contact/create', 'PeopleContactController@create')->name('people.contact.create');
        Route::post('{people}/contact', 'PeopleContactController@store')->name('people.contact.store');
        Route::get('{people}/contact/{contact}/edit', 'PeopleContactController@edit')->name('people.contact.edit');
        Route::patch('{people}/contact/{contact}', 'PeopleContactController@update')->name('people.contact.update');
        Route::delete('{people}/contact/{contact}', 'PeopleContactController@destroy')->name('people.contact.destroy');
    });
    
    Route::get('/contact', 'PeopleContactController@index')->name('people.contact.query');
    
    Route::prefix('customer')->group(function(){
        Route::get('', 'CustomerController@index')->name('customer.index');
        Route::get('create', 'CustomerController@create')->name('customer.create');
        Route::get('{customer}', 'CustomerController@show')->name('customer.show');
        Route::post('', 'CustomerController@store')->name('customer.store');
        Route::get('{customer}/edit', 'CustomerController@edit')->name('customer.edit');
        Route::patch('{customer}', 'CustomerController@update')->name('customer.update');
        Route::delete('{customer}', 'CustomerController@destroy')->name('customer.destroy');
    });
    
    
    Route::prefix('property')->group(function(){
        Route::get('', 'PropertyController@index')->name('property.index');
        // Route::get('estates', 'PropertyController@estates')->name('property.estates');
    });
    
    Route::prefix('estate')->group(function(){
        Route::get('{estate}/property/create', 'PropertyController@create')->name('property.create');
        Route::post('{estate}/property', 'PropertyController@store')->name('property.store');
        Route::get('{estate}/property/{property}', 'PropertyController@show')->name('property.show');
        Route::get('{estate}/property/{property}/edit', 'PropertyController@edit')->name('property.edit');
        Route::patch('{estate}/property/{property}', 'PropertyController@update')->name('property.update');
    
        Route::get('', 'EstateController@index')->name('estate.index');
        Route::get('create', 'EstateController@create')->name('estate.create');
        Route::post('', 'EstateController@store')->name('estate.store');
        Route::get('{estate}', 'EstateController@show')->name('estate.show');
        Route::get('{estate}/edit', 'EstateController@edit')->name('estate.edit');
        Route::patch('{estate}', 'EstateController@update')->name('estate.update');
    });
    
    Route::prefix('package')->group(function(){
        Route::get('', 'PackageController@index')->name('package.index');
        Route::get('create', 'PackageController@create')->name('package.create');
        Route::post('store', 'PackageController@store')->name('package.store');
        Route::get('{package}', 'PackageController@show')->name('package.show');
        Route::get('{package}/edit', 'PackageController@edit')->name('package.edit');
        Route::patch('{package}', 'PackageController@update')->name('package.update');
    });
    
    Route::prefix('transaction')->group(function(){
        Route::get('create', 'TransactionController@create')->name('transaction.create');
        Route::post('store', 'TransactionController@store')->name('transaction.store');
        Route::get('{transaction}', 'TransactionController@show')->name('transaction.show');
        Route::get('{transaction}/edit', 'TransactionController@edit')->name('transaction.edit');
        Route::patch('{transaction}/update', 'TransactionController@update')->name('transaction.update');
        Route::get('', 'TransactionController@index')->name('transaction.index');
    });

    Route::prefix('report')->group(function(){
        Route::get('performance', 'ReportPerformanceController@index')->name('report.performance.index');
    });
});

/*
Route::get('/translations', function(){
    return Cache::remember('translations', now()->addMinutes(1), function(){
        $locale = App::getLocale();
        $languages = glob("../resources/lang/{$locale}/*.php");
        return array_reduce($languages, function($carry, $file){
            $name = str_replace(".php", "", basename($file));
            
            $lang = Lang::get($name);
            $keys = array_map(function($key) use ($name){ return $name.".".$key; }, array_keys($lang));
            
            return array_merge($carry, array_combine($keys, $lang));
        }, []);
    });
});
*/

Route::get('/test', function(){
    $routeCollection = Route::getRoutes();
    phpinfo();
    dd();
    dd($routeCollection);
    return $routeCollection;
});
