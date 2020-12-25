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

use App\Room;
use Illuminate\Support\Facades\Route;
// ghep frontend - test
Route::get('/', 'GuestController@index')->name('home');

Route::get('/login', 'GuestController@get_login_register')->name('guest.login-register');

Route::post('/postLogin', 'GuestController@postLogin')->name('guest.postLogin');

Route::get('/logout', 'GuestController@logout')->name('guest.logout');

Route::post('/postRegister', 'GuestController@postRegister')->name('guest.postRegister');
// Route cho trang user profile
Route::get('/userprofile', 'GuestController@getProfile')->name('guest.userprofile');
Route::get('/profile-info', 'GuestController@getProfileinfo')->name('profile-info-page');
Route::get('/changePassword', 'GuestController@getChangePassword')->name('changePassword-page');
Route::get('/noti-page', 'GuestController@getNoti')->name('noti-page');
<<<<<<< HEAD
Route::get('/liked-rooms', 'GuestController@getLikedRooms')->name('liked-rooms');
Route::get('/liked-room', function (){
   return view('frontend.user.liked_room');
});
=======
>>>>>>> 032f69430ad6efda626c5ac697620a5f38a51951
// end route cho trang user profile
Route::get('/blog', 'GuestController@getAllPosts')->name('guest.blog');

Route::get('/blogDetail/{post_id}', 'GuestController@blogDetail')->name('guest.blogDetail');


Route::get('/room', 'GuestController@getAllRoom')->name('guest.allroom');

Route::get('/room/{room_id}', 'GuestController@showRoomDetail')->name('guest.showroom');

Route::match( ['put','patch'],'/updateProfile', 'GuestController@updateProfile')->name('guest.updateProfile');

Route::get('/getAvatarUser/{user_id}', 'GuestController@getLinkAvatarUser');

<<<<<<< HEAD
Route::get('/guestComment', 'GuestController@postComment');
=======
Route::get('/testpage', 'GuestController@test');
>>>>>>> 032f69430ad6efda626c5ac697620a5f38a51951

Route::get('/storeVoted/{room_id}/{count_star}', 'GuestController@storeVoted')->name('uservoted.store');

<<<<<<< HEAD
Route::get('/getVotedStar/{room_id}', 'GuestController@getRoomVotedStar');

Route::get('/storeLiked/{room_id}', 'GuestController@storeLiked')->name('likedroom.store');

Route::get('/deleteLikedRoom/{room_id}', 'GuestController@destroyLikedRoom');
// Cac route o day phuc vu cho viec select iframe page o trang user
=======
// Cac route o day phuc vu cho viec select iframe page o trang user


Route::get('/liked-rooms', function () {
    return view('frontend.user.liked_rooms');
});
// end iframe trang user
>>>>>>> 032f69430ad6efda626c5ac697620a5f38a51951

Route::get('/roomFilter/{under_p}/{r_type}/{c_id}/{d_id}/{w_owner}', 'SearchController@roomFilter')->name('guest.testFilter');

Route::get('/getSendReport/{room_id}', 'GuestController@getSendReport')->name('guest.getSendReport');
Route::get('/storeReport', 'GuestController@storeReport')->name('guest.storeReport');

//Route::get('/liked-rooms', function () {
//    return view('frontend.user.liked_rooms');
//});
// end iframe trang user

Route::get('/searchFromHome', 'SearchController@searchFromHome')->name('guest.searchFromHome');
Route::get('/searchByDistrict/{district_id}', 'SearchController@searchByDistrict')->name('guest.searchByDistrict');

//Route::get('/user/getAllRoomViewed', 'UserViewedController@getAllRoomViewed')->name('userviewed.getAllRoomViewed');
//Route::get('/user/storeRoomViewed/{user_id}/{room_id}', 'UserViewedController@storeViewed')->name('userviewed.store');


Route::get('/admin/login', 'AdminController@login')->name('admin.login');
//Route::get('/login', 'ShopController@login')->name('shop.login');
// Đăng xuất
Route::get('/admin/logout', 'AdminController@logout')->name('admin.logout');

Route::post('/admin/postLogin', 'AdminController@postLogin')->name('admin.postLogin');

// search fulltext route
Route::get('/room/search/{key_title}','SearchController@searchTitle')->name('searchTitle');

//Route::get('/sendNoti/{title}/{msg}/{receiver_id}', 'AdminController@sendNoti');

Route::get('/getListDistrict/{city_id}', 'AdminController@getListDistrict');

Route::get('/checkExistsEmail/{new_email}', 'UserController@checkExistEmail');

Route::get('/checkExistsCmnd/{new_cmnd}', 'UserController@checkExistCmnd');

Route::get('/checkOldPassword/{password}', 'UserController@checkOldPassword');

Route::post('/user/changePassword', 'UserController@changePassword')->name('postchangePassword');


Route::group(['prefix' => 'admin','as' => 'admin.', 'middleware' => ['checkLogin']], function() {
    Route::get('/', 'AdminController@index')->name('dashboard');
    Route::get('/errorPage', 'AdminController@errorPage')->name('error');
    Route::get('/room/search/{role}','RoomController@searchTitle')->name('searchTitleAdmin');
    Route::resource('room', 'RoomController');
    Route::get('/user/getListOwnerRequested', 'UserController@getListRequestedOwner')->name('user.getListOwnerRequested');
    Route::resource('user', 'UserController');
    Route::resource('roomtype', 'RoomTypeController');
    Route::resource('city', 'CityController');
    Route::resource('district', 'DistrictController');
    Route::get('/comment/getAllUnApprovedComments', 'CommentController@getAllUnApprovedComments')->name('comment.getAllUnApprovedComments');
    Route::resource('comment', 'CommentController');
    Route::get('/report/getAllUnApprovedReports', 'ReportController@getAllUnApprovedReports')->name('report.getAllUnApprovedReports');
    Route::resource('report', 'ReportController');
    Route::delete('/roomimage/{id}', 'RoomController@deleteRoomImage')->name('room.deleteRoomImage');
    Route::get('/showAllExtendRoomRequest', 'AdminController@showAllExtendRoomRequest')->name('showAllExtendRoomRequest');
    Route::get('/test', 'AdminController@test');
    Route::get('/approveExtendRequest/{request_id}','AdminController@extendDate')->name('approveExtendRequest');
    Route::get('/deleteRequest/writeReason/{request_id}', 'AdminController@writeReason')->name('deleteRequest.writeReason');
    Route::post('/deleteRequest/refuseRequest/{request_id}', 'AdminController@refuseExtendDate')->name('deleteRequest.refuseExtendDate');
    Route::get('/approveOwnerAccount/{owner_id}', 'AdminController@approveOwnerAccount')->name('approveOwnerAccount');
    Route::get('/getAllUnApprovedRoom', 'AdminController@getAllUnApprovedRoom')->name('getAllUnApprovedRoom');
    Route::get('/approveRoom/{id}', 'AdminController@approveRoom')->name('approveRoom');
    Route::get('/getAllRequestEditRoom', 'AdminController@getAllRequestEditRoom')->name('getAllRequestEditRoom');
    Route::get('/approveRequestEditRoom/{request_id}', 'AdminController@approveEditRoom');
    Route::get('/declineRequestEditRoom/{request_id}', 'AdminController@declineEditRoom');
    Route::get('/checkExpiredRoom', 'RoomController@checkExpired');

    Route::get('/mostViewedRoom', 'AdminController@getMostViewedRoom')->name('getMostViewedRoom');
    Route::get('/mostViewedRoombytime', 'AdminController@getMostViewedRoom_bytime')->name('getMostViewedRoombytime');


    Route::get('/mostLikedRoom', 'AdminController@getMostLikedRoom')->name('getMostLikedRoom');

    Route::resource('post', 'PostController');

});

Route::get('/owner/login', 'OwnerController@login')->name('owner.login');
Route::post('/owner/postLogin', 'OwnerController@postLogin')->name('owner.postLogin');

Route::get('/owner/register', 'OwnerController@register')->name('owner.register');
Route::post('/owner/postRegister', 'OwnerController@postRegister')->name('owner.postRegister');

Route::group(['prefix' => 'owner','as' => 'owner.', 'middleware' => ['checkLoginOwner']], function() {
    Route::get('/','OwnerController@getAllRoom')->name('room.index');
    Route::get('/room/show/{id}', 'OwnerController@showRoomDetail')->name('room.show');
    Route::get('/room/create', 'OwnerController@viewCreateRoom')->name('room.create');
    Route::post('/room/storeRoom', 'OwnerController@storeRoom')->name('room.storeRoom');
    Route::get('/room/edit/{id}', 'OwnerController@viewEditRoom')->name('room.edit');
    Route::match( ['put','patch'],'room/updateRoom/{id}', 'OwnerController@updateRoom')->name('room.update');
    Route::get('/room/extendDate/{roomId}', 'OwnerController@extendDate')->name('room.extendDate');
    Route::post('/room/extendDate/{roomId}', 'OwnerController@require_extendDate')->name('room.postextendDate');
    Route::delete('/roomimage/{id}', 'OwnerController@deleteRoomImage');
//    Route::post('/extend/{roomId}', 'OwnerController@viewExtend')->name('room.extend');
    Route::get('/requestEditRoom/{roomId}', 'OwnerController@requestEditRoom')->name('room.requestEdit');
    Route::post('/sendRequestEditRoom', 'OwnerController@sendRequestEditRoom')->name('room.sendRequestEditRoom');
    Route::get('/showProfile', 'OwnerController@showProfile')->name('showProfile');
    Route::get('/showNoti/{id}', 'OwnerController@showDetailNoti')->name('showNoti');
    Route::get('/showAllNoti', 'OwnerController@showAllNoti')->name('showAllNoti');
    Route::get('/changePassword', 'OwnerController@changePassword')->name('changePassword');
    Route::get('/editProfile', 'OwnerController@editProfile')->name('editProfile');
    Route::match( ['put','patch'],'/updateProfile', 'OwnerController@updateProfile')->name('updateProfile');
    Route::get('/markAsRead/{noti_id}', 'OwnerController@markAsRead')->name('markNotiAsRead');
    Route::get('/markAsUnRead/{noti_id}', 'OwnerController@markAsUnRead')->name('markNotiAsUnRead');
//    Route::get('/markAsRented/{room_id}', 'OwnerController@markAsRented')->name('markRoomAsRented');
    Route::get('/room/search/{role}','RoomController@searchTitle')->name('searchTitleOwner');
    Route::get('/test/{room_id}', 'OwnerController@test_owner');


});
