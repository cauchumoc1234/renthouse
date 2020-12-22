<link rel="stylesheet" href="../frontend/css/noti-page.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="container-fluid main">
    <div class="root">
        <h3>Thông báo</h3>
{{--        <nav id="pagnition">--}}
{{--            <ul class="pagination">--}}
{{--                <li class="page-item">--}}
{{--                    <a class="page-link" href="#" aria-label="Previous">--}}
{{--                        <span aria-hidden="true">&laquo;</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--                <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                <li class="page-item">--}}
{{--                    <a class="page-link" href="#" aria-label="Next">--}}
{{--                        <span aria-hidden="true">&raquo;</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </nav>--}}
        <div class="note-container">
            @foreach($data as $item)
                @if($item->be_seen == 0)
                    <div class="item unread">
                        <a href="#">{{ $item->content }}</a>
                        <p class="time">{{ $item->created_at }}</p>
                    </div>
                @else
                    <div class="item">
                        <a href="#">{{ $item->content }}</a>
                        <p class="time">13m ago</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</div>
<script src="../frontend/js/iframeResizer.contentWindow.min.js"></script>
