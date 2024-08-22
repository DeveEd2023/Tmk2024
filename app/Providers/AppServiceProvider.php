<?php

namespace App\Providers;

use App\Models\DatosUsuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.master', 'layouts.profesor', 'layouts.alumno'], function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $datos = DatosUsuario::select('usu_nombres', 'usu_apellidos', 'usu_rol_id')
                    ->where('id', $user->id)
                    ->first();

                $view->with([
                    'datoNombre' => $datos->usu_nombres,
                    'datoApellido' => $datos->usu_apellidos,
                    'datoRoll' => $datos->usu_rol_id,
                    'userid' => $user->id
                ]);
            }
        });
    }
}
