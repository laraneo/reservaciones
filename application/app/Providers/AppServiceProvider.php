<?php

namespace App\Providers;

use App\Settings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //set default string length to 191 characters

        Schema::defaultStringLength(191);

        //check if settings table is existing

        if(DB::connection()->getDatabaseName())
        {
            if(Schema::hasTable('settings'))
            {
                //get all column names for settings

                $columns = Schema::getColumnListing('settings');

                //get all settings

                $settings = Settings::query()->first();

                if($settings)
                {
                    //for each of columns array index
                    foreach ($columns as $column)
                    {
                        //set config as key settings.column_name = setting.value
                        Config::set('settings.'.$column, $settings->$column);
                    }

                    //set default currency symbol

                    if($settings->default_currency=="USD" || $settings->default_currency=="CAD"
                        || $settings->default_currency=="AUD" || $settings->default_currency=="NZD"  || $settings->default_currency=="SGD"
                        || $settings->default_currency=="HKD"
                    )
                    {
                        Config::set('settings.currency_symbol', '&dollar;');
                    }

                    if($settings->default_currency=="GBP")
                    {
                        Config::set('settings.currency_symbol', '&pound;');
                    }

                    if($settings->default_currency=="EUR")
                    {
                        Config::set('settings.currency_symbol', '&euro;');
                    }

                    if($settings->default_currency=="ARS" || $settings->default_currency=="MXN")
                    {
                        Config::set('settings.currency_symbol', '&#36;');
                    }

                    if($settings->default_currency=="BRL")
                    {
                        Config::set('settings.currency_symbol', '&#82;&#36;');
                    }

                    if($settings->default_currency=="DKK"  || $settings->default_currency=="SEK"  || $settings->default_currency=="NOK")
                    {
                        Config::set('settings.currency_symbol', '&#107;&#114;');
                    }

                    if($settings->default_currency=="INR")
                    {
                        Config::set('settings.currency_symbol', '&#8377;');
                    }

                    if($settings->default_currency=="CHF")
                    {
                        Config::set('settings.currency_symbol', '&#67;&#72;&#70;');
                    }

                    if($settings->default_currency=="JPY")
                    {
                        Config::set('settings.currency_symbol', '&#165;');
                    }

                    if($settings->default_currency=="RUB")
                    {
                        Config::set('settings.currency_symbol', '&#1088;&#1091;&#1073;');
                    }

                    if($settings->default_currency=="TRY")
                    {
                        Config::set('settings.currency_symbol', '&#8356;');
                    }

                    //set default language
                    App::setLocale($settings->lang);

                }

            }
        }

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
