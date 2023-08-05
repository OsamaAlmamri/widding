<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Spatie\Permission\Models\Role;

class ArtisanCommandsController extends Controller
{
    function clearCache()
    {
        $status = Artisan::call('config:cache');

        return '<h1>Cache cleared</h1>';
    }

    function getOS()
    {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform = "UnKnow OS";
        $os_array = array(
            '/windows nt 11/i' => 'Windows 11',
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        return $os_platform;
    }

    function app_link()
    {
        $ios = \App\CPU\Helpers::get_business_settings('download_app_apple_stroe');
        $android = \App\CPU\Helpers::get_business_settings('download_app_google_stroe');
//        return $android['link'];
$sys=$this->getOS();

        if ($sys == 'iPhone' ||$sys == 'iPad' ||$sys == 'iPod' )
            $link = $ios['link'];
        elseif ($sys=='Android')
            $link = $android['link'];
        else
            $link = env('APP_URL');

        return \Redirect::away($link);

    }


    function migrate()
    {

        DB::table('migrations')->where('migration', 'like', "%view_%")->delete();

       $status = Artisan::call('migrate');

        return '<h1>migrate success</h1>';
    }

    function role_seed()
    {

        $status = Artisan::call('db:seed --class=PermissionsSeeder');

        return '<h1>seed success</h1>';
    }

    function seed()
    {

        $status = Artisan::call('db:seed');

        return '<h1>seed success</h1>';
    }

    function routeCache()
    {
        $status = Artisan::call(' route:cache');

        return '<h1>Route  cleared,cached</h1>';
    }

    function optimizeCache()
    {
        try {
            $status = Artisan::call('optimize');

            return '<h1>optimize execute</h1>';
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function clearCompiled()
    {
        try {
            $status = Artisan::call('clear-compiled');

            return '<h1>clear-compiled execute</h1>';
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function storageLnk()
    {
        try {
            $status = Artisan::call('storage:link');

            return '<h1>storage linked</h1>';
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function telspub()
    {
        try {
            $status = Artisan::call('telescope:publish');

            return '<h1>tels pub</h1>';
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function keyGenerate()
    {
        try {
            $status = Artisan::call('key:generate');

            return '<h1>generated  </h1>' . $status;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function envIs()
    {
        try {
            $status = Artisan::call('env');

            return '<h1>env is  </h1>' . $status;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
