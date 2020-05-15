<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
//        view()->composer('', function () {
//
//        });

        // userList
        view()->composer(array('approval.approversettings.create', 'approval.approversettings.edit',
            'teaching.teachingadministrator.create', 'teaching.teachingadministrator.edit', 'purchase.payments.create_hxold',
            'changeuser'), function($view) {
            $view->with('userList', \App\User::where('email', '<>', 'admin@admin.com')->orderby('name', 'asc')->pluck('name', 'id'));
        });

        // forwarderuserList
        view()->composer(array('shipment.userforwarders.create', 'shipment.userforwarders.edit'), function($view) {
            $view->with('forwarderuserList', \App\User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('roles.name', 'forwarder')->orderby('users.name', 'asc')->pluck('users.name', 'users.id'));
        });

        // vendoruserList
        view()->composer(array('purchase.uservendors.create', 'purchase.uservendors.edit'), function($view) {
            $view->with('vendoruserList', \App\User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('roles.name', 'vendor')->orderby('users.name', 'asc')->pluck('users.name', 'users.id'));
        });

        // forwarderList
        view()->composer(array('shipment.userforwarders.create', 'shipment.userforwarders.edit'), function($view) {
            $view->with('forwarderList', \App\Models\Shipment\Shipment::whereNotNull('forwarder')->distinct()->pluck('forwarder', 'forwarder'));
        });

        // vendorList
        view()->composer(array('purchase.uservendors.create', 'purchase.uservendors.edit'), function($view) {
            $view->with('vendorList', \App\Models\Purchase\Vendor::orderby('name')->pluck('name', 'id'));
        });

        // oadepartmentList
        view()->composer(array('system.reports.statisticsindex'), function($view) {
            $view->with('oadepartmentList', \App\Models\Personal\OrgUnit::orderby('code')->pluck('name', 'name'));
        });

        //partList
        view()->composer(array('department6.inquiry_sheets.mcreate'), function($view) {
            $view->with('partList', \App\Models\Department6\Part::orderby('name')->pluck('name', 'id'));
        });

        //ingredientList
        view()->composer(array('department6.inquiry_sheets.mcreate'), function($view) {
            $view->with('ingredientList', \App\Models\Department6\Ingredient::orderby('name')->pluck('name', 'id'));
        });

        //processList
        view()->composer(array('department6.inquiry_sheets.mcreate'), function($view) {
            $view->with('processList', \App\Models\Department6\Process::orderby('name')->pluck('name', 'id'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
