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

Route::group(['middleware' => 'guest'], function () {
    /**
     * Auth
     */
    Route::get('/signin', [
        'uses' => 'AuthController@getSignin',
        'as' => 'auth.signin'
    ]);

    Route::post('/signin', [
        'uses' => 'AuthController@postSignin',
        'as' => 'auth.signin'
    ]);

    Route::get('/signup', [
        'uses' => 'AuthController@getSignup',
        'as' => 'auth.signup'
    ]);

    Route::post('/signup', [
        'uses' => 'AuthController@postSignup',
        'as' => 'auth.signup'
    ]);

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [
        'uses' => 'HomeController@index',
        'as' => 'home'
    ]);
    Route::get('/home', [
        'uses' => 'HomeController@index',
        'as' => 'home'
    ]);

    /**
     * Search
     */
    Route::get('/search', [
        'uses' => 'SearchController@index',
        'as' => 'search.index'
    ]);

    Route::get('/search/people', [
        'uses' => 'SearchController@searchPeople',
        'as' => 'search.people'
    ]);

    Route::get('/search/posts', [
        'uses' => 'SearchController@searchPosts',
        'as' => 'search.posts'
    ]);

    Route::get('/search/comments', [
        'uses' => 'SearchController@searchComments',
        'as' => 'search.comments'
    ]);

    /**
     * Profile
     */
    Route::get('/u/{username}', [
        'uses' => 'ProfileController@index',
        'as' => 'user.profile'
    ]);

    Route::get('/u/{username}/avatar', [
        'uses' => 'ProfileController@getAvatar',
        'as' => 'user.avatar'
    ]);

    Route::get('/u/{username}/followers', [
        'uses' => 'ProfileController@getFollowers',
        'as' => 'user.followers'
    ]);

    Route::get('/u/{username}/following', [
        'uses' => 'ProfileController@getFollowing',
        'as' => 'user.following'
    ]);

    Route::get('/u/{username}/timeline', [
        'uses' => 'ProfileController@getTimeline',
        'as' => 'user.timeline'
    ]);

    /**
     * Likes
     */
    Route::get('/u/{username}/likes', [
        'uses' => 'ProfileController@getLikes',
        'as' => 'user.likes'
    ]);

    Route::get('/u/{username}/likes/posts', [
        'uses' => 'ProfileController@getPostLikes',
        'as' => 'user.likes.posts'
    ]);

    Route::get('/u/{username}/likes/comments', [
        'uses' => 'ProfileController@getCommentLikes',
        'as' => 'user.likes.comments'
    ]);

    Route::get('/like/{type}/{id}', [
        'uses' => 'ProfileController@getLike',
        'as' => 'like'
    ]);

    Route::get('/unlike/{type}/{id}', [
        'uses' => 'ProfileController@getUnlike',
        'as' => 'unlike'
    ]);

    Route::get('/like/{type}/{id}/users', [
        'uses' => 'ProfileController@getLikeUsers',
        'as' => 'like.users'
    ]);


    Route::get('/follow/{id}', [
        'uses' => 'ProfileController@getFollow',
        'as' => 'user.follow'
    ]);

    Route::get('/unfollow/{id}', [
        'uses' => 'ProfileController@getUnfollow',
        'as' => 'user.unfollow'
    ]);

    Route::get('/accept_request/{id}', [
        'uses' => 'ProfileController@getAcceptRequest',
        'as' => 'user.follow.accept'
    ]);

    Route::get('/delete_request/{id}', [
        'uses' => 'ProfileController@getDeleteRequest',
        'as' => 'user.follow.delete'
    ]);


    /**
     * Avatar
     */
    Route::post('/avatar/upload', [
        'uses' => 'ProfileController@uploadAvatar',
        'as' => 'avatar.upload'
    ]);

    Route::post('/avatar/delete', [
        'uses' => 'ProfileController@deleteAvatar',
        'as' => 'avatar.delete'
    ]);

    /**
     * Account
     */
    Route::get('/account', [
        'uses' => 'AccountController@index',
        'as' => 'account.index'
    ]);

    Route::get('/account/edit', [
        'uses' => 'AccountController@edit',
        'as' => 'account.edit'
    ]);

    Route::post('/account/edit', [
        'uses' => 'AccountController@update',
        'as' => 'account.update'
    ]);

    Route::get('/account/security', [
        'uses' => 'AccountController@security',
        'as' => 'account.security'
    ]);

    /**
     * Post
     */
    Route::resource('post', 'PostController');

    /**
     * Auth
     */
    Route::get('/logout', [
        'uses' => 'AuthController@getLogout',
        'as' => 'auth.logout'
    ]);
});

/**
 * API Routes (Auth Required!)
 */
Route::group(['prefix'=> 'api', 'middleware'=>'auth'], function () {
    Route::get('/countries/', [
        'uses' => 'ApiController@getCountries',
        'as' => 'api.countries'
    ]);
    Route::get('/search/people', [
        'uses' => 'ApiController@searchPeople',
        'as' => 'api.search.people'
    ]);
});
