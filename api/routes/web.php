<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['namespace' => 'V2'], function() use ($router)
{

    $router->group(['prefix' => 'v2'], function () use ($router) {
        $router->post('login', [
            'as' => 'userLogin', 'uses' => 'AuthController@authenticate'
        ]);
    });

    #$router->group(['prefix' => 'v2'], function () use ($router) {
    $router->group(['prefix' => 'v2', 'middleware' => 'jwt.auth'], function () use ($router) {
        //Maker
        $router->get('maker', [
            'as' => 'makers', 'uses' => 'MakerController@index'
        ]);
        $router->post('maker', [
            'as' => 'makerAdd', 'uses' => 'MakerController@add'
        ]);
        $router->get('maker/{id}', [
            'as' => 'makerView', 'uses' => 'MakerController@view'
        ]);
        $router->put('maker/{id}', [
            'as' => 'makerUpdate', 'uses' => 'MakerController@update'
        ]);
        $router->delete('maker/{id}', [
            'as' => 'makerDelete', 'uses' => 'MakerController@delete'
        ]);
        //MakerImage
        $router->get('maker/{id}/image', [
            'as' => 'makerImages', 'uses' => 'MakerImageController@index'
        ]);
        $router->post('maker/{id}/image', [
            'as' => 'makerAddImage', 'uses' => 'MakerImageController@add'
        ]);
        $router->get('maker/{id}/image/{imgId}', [
            'as' => 'makerGetImage', 'uses' => 'MakerImageController@download'
        ]);
        $router->delete('maker/{id}/image/{imgId}', [
            'as' => 'makerDeleteImage', 'uses' => 'MakerImageController@delete'
        ]);
        //Media
        $router->get('media', [
            'as' => 'medias', 'uses' => 'MediaController@index'
        ]);
        $router->post('media', [
            'as' => 'mediaAdd', 'uses' => 'MediaController@add'
        ]);
        $router->get('media/{id}', [
            'as' => 'mediaView', 'uses' => 'MediaController@view'
        ]);
        $router->put('media/{id}', [
            'as' => 'mediaUpdate', 'uses' => 'MediaController@update'
        ]);
        $router->delete('media/{id}', [
            'as' => 'mediaDelete', 'uses' => 'MediaController@delete'
        ]);
        //Region
        $router->get('region', [
            'as' => 'regions', 'uses' => 'RegionController@index'
        ]);
        $router->post('region', [
            'as' => 'regionAdd', 'uses' => 'RegionController@add'
        ]);
        $router->get('region/{id}', [
            'as' => 'regionView', 'uses' => 'RegionController@view'
        ]);
        $router->put('region/{id}', [
            'as' => 'regionUpdate', 'uses' => 'RegionController@update'
        ]);
        $router->delete('region/{id}', [
            'as' => 'regionDelete', 'uses' => 'RegionController@delete'
        ]);
        //BusinessType
        $router->get('businesstype', [
            'as' => 'businesstypes', 'uses' => 'BusinessTypeController@index'
        ]);
        $router->post('businesstype', [
            'as' => 'businesstypeAdd', 'uses' => 'BusinessTypeController@add'
        ]);
        $router->get('businesstype/{id}', [
            'as' => 'businesstypeView', 'uses' => 'BusinessTypeController@view'
        ]);
        $router->put('businesstype/{id}', [
            'as' => 'businesstypeUpdate', 'uses' => 'BusinessTypeController@update'
        ]);
        $router->delete('businesstype/{id}', [
            'as' => 'businesstypeDelete', 'uses' => 'BusinessTypeController@delete'
        ]);
        //MakerGroup
        $router->get('makergroup', [
            'as' => 'makergroups', 'uses' => 'MakerGroupController@index'
        ]);
        $router->post('makergroup', [
            'as' => 'makergroupAdd', 'uses' => 'MakerGroupController@add'
        ]);
        $router->get('makergroup/{id}', [
            'as' => 'makergroupView', 'uses' => 'MakerGroupController@view'
        ]);
        $router->put('makergroup/{id}', [
            'as' => 'makergroupUpdate', 'uses' => 'MakerGroupController@update'
        ]);
        $router->delete('makergroup/{id}', [
            'as' => 'makergroupDelete', 'uses' => 'MakerGroupController@delete'
        ]);
        //ServiceType
        $router->get('servicetype', [
            'as' => 'servicetypes', 'uses' => 'ServiceTypeController@index'
        ]);
        $router->post('servicetype', [
            'as' => 'servicetypeAdd', 'uses' => 'ServiceTypeController@add'
        ]);
        $router->get('servicetype/{id}', [
            'as' => 'servicetypeView', 'uses' => 'ServiceTypeController@view'
        ]);
        $router->put('servicetype/{id}', [
            'as' => 'servicetypeUpdate', 'uses' => 'ServiceTypeController@update'
        ]);
        $router->delete('servicetype/{id}', [
            'as' => 'servicetypeDelete', 'uses' => 'ServiceTypeController@delete'
        ]);
        //Product
        $router->get('product', [
            'as' => 'products', 'uses' => 'ProductController@index'
        ]);
        $router->post('product', [
            'as' => 'productAdd', 'uses' => 'ProductController@add'
        ]);
        $router->get('product/{id}', [
            'as' => 'productView', 'uses' => 'ProductController@view'
        ]);
        $router->put('product/{id}', [
            'as' => 'productUpdate', 'uses' => 'ProductController@update'
        ]);
        $router->delete('product/{id}', [
            'as' => 'productDelete', 'uses' => 'ProductController@delete'
        ]);
        //Project
        $router->get('project', [
            'as' => 'projects', 'uses' => 'ProjectController@index'
        ]);
        $router->post('project', [
            'as' => 'projectAdd', 'uses' => 'ProjectController@add'
        ]);
        $router->get('project/{id}', [
            'as' => 'projectView', 'uses' => 'ProjectController@view'
        ]);
        $router->put('project/{id}', [
            'as' => 'projectUpdate', 'uses' => 'ProjectController@update'
        ]);
        $router->delete('project/{id}', [
            'as' => 'projectDelete', 'uses' => 'ProjectController@delete'
        ]);
        //ProjectImage
        $router->get('project/{id}/image', [
            'as' => 'projectImages', 'uses' => 'ProjectImageController@index'
        ]);
        $router->post('project/{id}/image', [
            'as' => 'projectAddImage', 'uses' => 'ProjectImageController@add'
        ]);
        $router->get('project/{id}/image/{imgId}', [
            'as' => 'projectGetImage', 'uses' => 'ProjectImageController@download'
        ]);
        $router->delete('project/{id}/image/{imgId}', [
            'as' => 'projectDeleteImage', 'uses' => 'ProjectImageController@delete'
        ]);
        
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->get('require_auth', function () {
                return 'Hello in this restricted area';
            });
        });
    });
});