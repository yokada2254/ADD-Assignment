<?php
namespace App\Http\ViewComposers;

use App\Models\PackageStatus;
use App\Models\TransactionType;
use App\Models\Area;
use App\Models\EstateType;
use App\Models\Branch;
use App\Models\User;
use App\Models\CustomerStatus;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;


class PreloadOptionsComposer
{
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('translations', Cache::remember('translations', 600, function(){
            $locale = App::getLocale();
            $languages = glob("../resources/lang/{$locale}/*.php");
            $translations = array_reduce($languages, function($carry, $file){
                $name = str_replace(".php", "", basename($file));
                
                $lang = Lang::get($name);
                $keys = array_map(function($key) use ($name){ return $name.".".$key; }, array_keys($lang));
                
                return array_merge($carry, array_combine($keys, $lang));
            }, []);

            return json_encode($translations);
        }));

        $view->with('package_statuses', Cache::remember('package_statuses', 600, function(){
            return PackageStatus::all();
        }));

        $view->with('transaction_types', Cache::remember('transaction_types', 600, function(){
            return TransactionType::all();
        }));
        
        $view->with('property_options', Cache::remember('property_options', 600, function(){
            $areas_districts = Area::with('districts.estates')->get();
            $estate_types = EstateType::all();

            return json_encode([
                'areas_districts' => $areas_districts->toArray(),
                'estate_types' => $estate_types->toArray()
            ]);
        }));

        $view->with('branches', Cache::remember('branches', 600, function(){
            return Branch::all('id', 'name');
        }));
        $view->with('users', Cache::remember('users', 60, function(){
            return User::all('id', 'name', 'branch_id', 'license');
        }));

        $view->with('customer_statuses', Cache::remember('customer_statuses', 600, function(){
            return CustomerStatus::all();
        }));
    }
}