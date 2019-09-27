<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group([
    'prefix' => 'saml_admin'
],function(){
    Route::get('/', function(){
        return redirect()->to(url('samllogin/module.php/core/frontpage_welcome.php'));
    })->name('samlconfigPage');
    Route::get('/federationConverter', function(){
        return redirect()->to(url('samllogin/admin/metadata-converter.php'));
    })->name('federationConverter');
});
Route::get('/login_via_saml', function(){
    $as = new SimpleSAML_Auth_Simple('default-sp');
    $as->requireAuth();
    $attributes = $as->getAttributes();
    $url = $as->getLogoutURL();
    if(isset($attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'][0])){
        $emailAddress = $attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'][0];
    }else{
        $emailAddress = $attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'][0];
    }
    $data = [
        'samlUserData'  => [
            'tenantId'         => $attributes['http://schemas.microsoft.com/identity/claims/tenantid'][0],
            'objectIdentifier' => $attributes['http://schemas.microsoft.com/identity/claims/objectidentifier'][0],
            'surname'          => $attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname'][0],
            'givenName'        => $attributes['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname'][0],
            'displayName'      => $attributes['http://schemas.microsoft.com/identity/claims/displayname'][0],
            'emailAddress'     => $emailAddress ,
            'identityProvider' => $attributes['http://schemas.microsoft.com/identity/claims/identityprovider'][0],
        ],
        'logoutURL' => $url
    ];
    $ifUserExist = User::where('email',$data['samlUserData']['emailAddress'])->first();
    if($ifUserExist !== null){
        Auth::attempt(['email' => $data['samlUserData']['emailAddress'], 'password' => $data['samlUserData']['emailAddress']]);
    }else{
        User::create([
            'name' => $data['samlUserData']['displayName'],
            'email' => $data['samlUserData']['emailAddress'],
            'password' => Hash::make($data['samlUserData']['emailAddress']),
        ]);
        Auth::attempt(['email' => $data['samlUserData']['emailAddress'], 'password' => $data['samlUserData']['emailAddress']]);
    }
    Session::put('samlLogoutURL', $data['logoutURL']);
    return redirect()->route('home');
})->name('loginViaSaml');
Route::get('logout','Auth\LoginController@logout')->name('logout');
