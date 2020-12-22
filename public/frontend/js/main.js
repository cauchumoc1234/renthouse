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

function storeLikedRoom(room_id) {
    $.ajax({
        url: base_url + '/storeLiked/'+room_id, // base_url được khai báo ở đầu page == http://renthouse.co
        type: 'GET',
        data: {}, // dữ liệu truyền sang nếu có
        dataType: "json", // kiểu dữ liệu trả về
        success: function (response) { // success : kết quả trả về sau khi gửi request ajax
            if(response == true) {
                $('.storeliked-msg').html('Phòng đã được lưu vào danh sách yêu thích.');
                console.log('saved this room!');
            } else {
                $('.storeliked-msg').html('Vui lòng đăng nhập để lưu phòng.');
                console.log('please login to saved this room!');
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
                console.log('saved this room!');
            } else {
                $('.storeliked-msg').html('Vui lòng đăng nhập để bình luận.');
                console.log('please login to saved this room!');
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
        console.log('chua chon sao de vote');
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
                    console.log('voted success!');
                    updateVotedStar(room_id);
                } else {
                    $('.storeliked-msg').html('Vui lòng đăng nhập để đánh giá.');
                    console.log('please login to vote this room!');
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
            console.log(response);
            $('span').remove('#star-icon');
            $('#voted-content').html(response + ' sao');
            for(i=0; i<response; i++) {
                $('.star').append(light_element);
            }
            for(i=0; i<5-response; i++) {
                $('.star').append(unlight_element);
            }
            console.log('success');
            // if(response == 0)
        },
        error: function (e) { // lỗi nếu có
            console.log(e.message);
        }
    });
}

