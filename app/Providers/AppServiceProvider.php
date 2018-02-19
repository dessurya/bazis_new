<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

// use Auth;

use App\Models\BankPenerimaZIS;
use App\Models\PublicContent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // view()->composer('*', function ($view){
        //     dd(Auth::user());
        // });

        $lgBazis = PublicContent::where('category', 'data_bazis')->where('title', 'logo bazis')->first();
        view()->share('lgBazis', $lgBazis);

        $alamat = PublicContent::where('category', 'data_bazis')->where('title', 'Alamat')->first();
        view()->share('alamat', $alamat);
        
        $telpon = PublicContent::where('category', 'data_bazis')->where('title', 'Telepon')->first();
        view()->share('telpon', $telpon);

        $fax = PublicContent::where('category', 'data_bazis')->where('title', 'Fax')->first();
        view()->share('fax', $fax);

        $email = PublicContent::where('category', 'data_bazis')->where('title', 'Email')->first();
        view()->share('email', $email);
        
        $medsos = PublicContent::where('category', 'media_sosial')->where('flag', 'Y')->get();
        view()->share('medsos', $medsos);
        
        $BankPenerimaZIS    = BankPenerimaZIS::orderBy('updated_at','desc')->where('flag', 'Y')->limit(5)->get();
        view()->share('BankPenerimaZIS', $BankPenerimaZIS);


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
