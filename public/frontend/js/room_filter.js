$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
getAllDistrict();
function getAllDistrict() {
    let city_id = $('#city').val();

    $.ajax({
        url: base_url + '/getListDistrict/'+city_id,
        type: 'GET',
        data: {}, // dữ liệu truyền sang nếu có
        dataType: "json", // kiểu dữ liệu trả về
        success: function (response) { // success : kết quả trả về sau khi gửi request ajax
            // dữ liệu trả về là một object nên để gọi đến status chúng ta sẽ gọi như bên dưới
            //     console.log(response);
            $('#district').html('');
            let default_el = `<option value="0">-- Chọn quận/huyện --</option>`;
            $('#district').append(default_el);
            $.each(response, function (i, item) {
                el = `<option value="${item.id}">${item.name}</option>`;
                $('#district').append(el);
            })
        },
        error: function (e) { // lỗi nếu có
            console.log(e.message);
        }
    });
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

function filterRoom() {

    let under_price = $('#price').val();
    let room_type = $('#room-type').val();
    let city_id = $('#city').val();
    let district_id = $('#district').val();
    let w_owner = $('#with_owner').val();

    // console.log(under_price + " " + room_type + " " + city_id + " " + district_id);

    $.ajax({
        url: base_url + '/roomFilter/'+under_price+'/'+room_type+'/'+city_id+'/'+district_id+'/'+w_owner, //
        type: 'GET',
        data: {}, // dữ liệu truyền sang nếu có
        dataType: "json", // kiểu dữ liệu trả về
        success: function (response) { // success : kết quả trả về sau khi gửi request ajax
            // dữ liệu trả về là một object nên để gọi đến status chúng ta sẽ gọi như bên dưới
            if(response.status == false) {
                $('.noti-msg').html(response.msg);
            } else {
                $('#page-title').html('Kết quả lọc');
                $('.rooms').empty();
                $.each(response.data, function (index, value) {
                    let room_element = ` <a href="http://renthouse.co/room/${value.id}" id="room-${value.id}" class="my-room">
                            <div class="room row">
                                <div class="room-img col-md-5 col-sm-6 col-12">
                                    <img src="http://renthouse.co/${value.image}" alt="Ảnh của ${value.title}" style="max-height: 247.09px!important">
                                </div>
                                <div class="room-info col">
                                    <p class="room-name">
                                        ${value.title}
                                    </p>
                                    <div class="room-detail">
                                        <div class="line-1 line">
                                            <span class="icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                                                            <span>Còn phòng</span>
                                                                                    </div>
                                        <div class="line line-2">
                                            <span class="icon"><i class="fas fa-user-friends"></i></span>
                                            <span>Nam & Nữ</span>
                                        </div>
                                        <div class="line line-3">
                                            <span class="icon"><i class="fas fa-ruler    "></i></span>
                                            <span>${value.area} m<sup style="font-size: 10px;">2</sup></span>
                                        </div>
                                        <div class="line line-4">
                                            <span class="icon"><i class="fas fa-map-marked    "></i></span>
                                            <span>${value.address}</span>
                                        </div>
                                        <div class="line line-5">
                                            <span class="icon"><i class="fas fa-money-check    "></i></span>
                                            <span class="price">${formatNumber(value.price)} đồng/tháng</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <hr>`;
                    $('.rooms').append(room_element);
                });

                $('.noti-msg').html(response.msg);
            }
            //     console.log(response);
            // console.log(response);
            // console.log(response.data);
            // $('#district').html('');
            // $.each(response, function (i, item) {
            //     el = `<option value="${item.id}">${item.name}</option>`;
            //     $('#district').append(el);
            // })
        },
        error: function (e) { // lỗi nếu có
            console.log(e.message);
        }
    });
}
