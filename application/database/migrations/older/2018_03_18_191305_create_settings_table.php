<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('google_maps_api_key')->nullable();
            $table->string('google_calendar_id')->nullable();
            $table->boolean('sync_events_to_calendar')->default(0);
            $table->text('stripe_test_key_pk')->nullable();
            $table->text('stripe_test_key_sk')->nullable();
            $table->text('stripe_live_key_pk')->nullable();
            $table->text('stripe_live_key_sk')->nullable();
            $table->boolean('stripe_enabled')->default(0);
            $table->boolean('stripe_sandbox_enabled')->default(1);
            $table->text('paypal_client_id')->nullable();
            $table->text('paypal_client_secret')->nullable();
            $table->boolean('paypal_enabled')->default(0);
            $table->boolean('paypal_sandbox_enabled')->default(1);
            $table->boolean('weekend_bookings')->default(1);
            $table->string('booking_time_start')->nullable();
            $table->string('booking_time_end')->nullable();
            $table->integer('days_limit_to_cancel')->nullable();
            $table->boolean('allow_to_cancel')->default(0);
            $table->integer('days_limit_to_update')->nullable();
            $table->boolean('allow_to_update')->default(0);
            $table->integer('slots_method')->default(1);
            $table->string('enable_gst')->default(0);
            $table->float('gst_percentage')->default(0);
            $table->string('business_name')->default('bookify');
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('default_currency')->default('USD');
            $table->string('contact_email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('google_plus_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('pinterest_link')->nullable();
            $table->text('freshchat_widget')->nullable();
            $table->string('lang')->default('en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
