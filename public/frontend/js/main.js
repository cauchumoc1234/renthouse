$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// function search fulltext tile room,da lay dc du lieu json, se viet js in ra web khi co frontend
function searchTitle(key_title) {

        $.ajax({
            url: base_url + '/room/search/'+key_title, // base_url được khai báo ở đầu page == http://renthouse.co
            type: 'GET',
            data: {}, // dữ liệu truyền sang nếu có
            dataType: "json", // kiểu dữ liệu trả về
            success: function (response) { // success : kết quả trả về sau khi gửi request ajax
                console.log(response);
            },
            error: function (e) { // lỗi nếu có
                console.log(e.message);
            }
        });
}
function getAvatarUser(user_id) {
    $.ajax({
        url: base_url + '/getAvatarUser/'+user_id, // base_url được khai báo ở đầu page == http://renthouse.co
        type: 'GET',
        data: {}, // dữ liệu truyền sang nếu có
        dataType: "json", // kiểu dữ liệu trả về
        success: function (response) { // success : kết quả trả về sau khi gửi request ajax
            $('#user_image').attr('src', response);
            $('#profile-picture').attr('src', response);
        },
        error: function (e) { // lỗi nếu có
            console.log(e.message);
        }
    });
}

<<<<<<< HEAD
function storeLikedRoom(room_id) {
    $.ajax({
        url: base_url + '/storeLiked/'+room_id, // base_url được khai báo ở đầu page == http://renthouse.co
        type: 'GET',
        data: {}, // dữ liệu truyền sang nếu có
        dataType: "json", // kiểu dữ liệu trả về
        success: function (response) { // success : kết quả trả về sau khi gửi request ajax
            if(response == true) {
                $('.storeliked-msg').html('Phòng đã được lưu vào danh sách yêu thích.');
            } else {
                $('.storeliked-msg').html('Vui lòng đăng nhập để lưu phòng.');
            }
        },
        error: function (e) { // lỗi nếu có
            console.log(e.message);
        }
    });
}

function userComment(room_id) {
    console.log('run usercomment function');
    let cmt = $('#user_comment').val();
    $.ajax({
        url: base_url + '/guestComment', // base_url được khai báo ở đầu page == http://renthouse.co
        type: 'GET',
        data: { 'comment' : cmt, 'room_id' : room_id }, // dữ liệu truyền sang nếu có
        dataType: "json", // kiểu dữ liệu trả về
        success: function (response) { // success : kết quả trả về sau khi gửi request ajax
            console.log(response);
            if(response == true) {
                $('.storeliked-msg').html('Bạn đã gửi bình luận thành công. Vui lòng đợi duyệt trước khi được hiển thị.');
            } else {
                $('.storeliked-msg').html('Vui lòng đăng nhập để bình luận.');
            }
        },
        error: function (e) { // lỗi nếu có
            console.log(e.message);
        }
    });
}

function storeVoted(room_id) {
    console.log('run storevoted function');
    let count_star = $('input[name=rate]:checked', '#myForm').val();
    if(count_star == undefined)
    {
        $('.storeliked-msg').html('Vui lòng chọn sao để gửi đánh giá');
    }
    else {
        $.ajax({
            url: base_url + '/storeVoted/'+room_id+'/'+count_star, // base_url được khai báo ở đầu page == http://renthouse.co
            type: 'GET',
            data: {}, // dữ liệu truyền sang nếu có
            dataType: "json", // kiểu dữ liệu trả về
            success: function (response) { // success : kết quả trả về sau khi gửi request ajax
                console.log(response);
                if(response == true) {
                    $('.storeliked-msg').html('Bạn đã gửi đánh giá thành công');
                    updateVotedStar(room_id);
                } else {
                    $('.storeliked-msg').html('Vui lòng đăng nhập để đánh giá.');
                }
            },
            error: function (e) { // lỗi nếu có
                console.log(e.message);
            }
        });
    }

}

function updateVotedStar(room_id) {
    let unlight_element = `<span class="fa fa-star" id="star-icon"></span>`;
    let light_element = `<span class="fa fa-star st-checked" id="star-icon"></span>`;
    $.ajax({
        url: base_url + '/getVotedStar/'+room_id, // base_url được khai báo ở đầu page == http://renthouse.co
        type: 'GET',
        data: {}, // dữ liệu truyền sang nếu có
        dataType: "json", // kiểu dữ liệu trả về
        success: function (response) { // success : kết quả trả về sau khi gửi request ajax
            $('span').remove('#star-icon');
            $('#voted-content').html(response + ' sao');
            for(i=0; i<response; i++) {
                $('.star').append(light_element);
            }
            for(i=0; i<5-response; i++) {
                $('.star').append(unlight_element);
            }
            // if(response == 0)
        },
        error: function (e) { // lỗi nếu có
            console.log(e.message);
        }
    });
}

function destroyLikedRoom(id) {
    // console.log('run this function');
    var result = confirm("Bạn có chắc chắn muốn xóa phòng đã thích ?");
    if (result) { // neu nhấn == ok , sẽ send request ajax
        $.ajax({
            url: base_url + '/deleteLikedRoom/'+id, // base_url được khai báo ở đầu page == http://renthouse.co
            type: 'GET',
            data: {}, // dữ liệu truyền sang nếu có
            dataType: "json", // kiểu dữ liệu trả về
            success: function (response) { // success : kết quả trả về sau khi gửi request ajax
                // dữ liệu trả về là một object nên để gọi đến status chúng ta sẽ gọi như bên dưới
                if (response.status != 'undefined' && response.status == true) {
                    console.log('xoa phong thanh cong');
                    // xóa dòng vừa được click delete
                    $('#room-'+id).remove();
                    // $('.item-'+id).closest('tr').remove(); // class .item- ở trong class của thẻ td đã khai báo trong file index
                }
            },
            error: function (e) { // lỗi nếu có
                console.log(e.message);
            }
        });
    }
}
// fix profile drop menu
function show_profiledropdown() {
    $('.drop-menu').css({'opacity': '5',"visibility":"visible"});
    $('.drop-menu').css('z-index', '99');

    $('.drop-menu').show();
}
function hide_profiledropdown() {
    $('.drop-menu').css({'opacity': '0',"visibility":"hidden"});
    $('.drop-menu').hide();

}

function storeReport() {
    let content = $('#content').val().trim();
    let room_id = $('#room_id').val();
    if(content != '')
    {
        $.ajax({
            url: base_url + '/storeReport', // base_url được khai báo ở đầu page == http://renthouse.co
            type: 'GET',
            data: { 'room_id' : room_id, 'content' : content }, // dữ liệu truyền sang nếu có
            dataType: "json", // kiểu dữ liệu trả về
            success: function (response) { // success : kết quả trả về sau khi gửi request ajax
                if (response.status == true) {
                    $('.storeliked-msg').html(response.msg);
                    // updateVotedStar(room_id);
                } else {
                    $('.storeliked-msg').html(response.msg);
                }
            },
            error: function (e) { // lỗi nếu có
                console.log(e.message);
            }
        });
    } else {
        $('.storeliked-msg').html("Vui lòng nhập nội dung báo cáo");
    }



}
=======
>>>>>>> 032f69430ad6efda626c5ac697620a5f38a51951
