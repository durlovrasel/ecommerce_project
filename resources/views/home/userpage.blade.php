<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{ asset('home/images/favicon.png') }}" type="">
    <title>Famms - Fashion HTML Template</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css') }}" />
    <!-- font awesome style -->
    <link href="{{ asset('home/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" />
</head>

<body>
    
    @include('sweetalert::alert')


    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->
        <!-- slider section -->
        @include('home.slider')
        <!-- end slider section -->
    </div>
    <!-- why section -->
    @include('home.why')
    <!-- end why section -->

    <!-- arrival section -->
    @include('home.new_arrival')
    <!-- end arrival section -->

    <!-- product section -->
    @include('home.product')
    <!-- end product section -->

    <!-- Comment & Reply System Starts from Here -->
    <div style="text-align: center; padding-bottom: 30px;">
        <h1 style="text-align: center; font-size: 30px; padding-top: 20px; 
        padding-bottom: 20px;">
            <b>Comments</b>
        </h1>

        <form action="{{ url('add_comment') }}" method="POST">
            @csrf
            <textarea name="comment" placeholder="Comment Something Here" style="height: 150px; width: 600px; " required></textarea>
            <br>
            <input type="submit" value="Comment" class="btn btn-primary">
        </form>
    </div>
    <div style="padding-left: 20%">
        <h1 style="padding-bottom: 20px; font-size: 20px;">All Comments</h1>
        @foreach ($comments as $comment)
            <div>
                <b>{{ $comment->name }}</b>
                <p>{{ $comment->comment }}</p>
                <a href="javascript::void(0);" onclick="reply(this)" data-Commentid="{{ $comment->id }}"
                    style="color: blue;">Reply</a>
                @foreach ($replies as $reply)
                    @if ($reply->comment_id == $comment->id)
                        <div style="padding-left: 3%; padding-top: 10px; padding-bottom: 10px;">
                            <b>{{ $reply->name }}</b>
                            <p>{{ $reply->reply }}</p>
                            <a href="javascript::void(0);" onclick="reply(this)" data-Commentid="{{ $comment->id }}"
                                style="color: blue;">Reply</a>
                        </div>
                    @endif
                @endforeach

            </div>
        @endforeach

        <!-- Reply Text Box Starts -->
        <div style="display: none;" class="replyDiv">
            <form action="{{ url('add_reply') }}" method="POST">
                @csrf
                <input type="text" id="commentId" name="commentId" hidden>
                <textarea style="height: 100px; width: 500px;" name="reply" placeholder="Write Something Here" required></textarea>
                <br>
                <button type="submit" value="Reply" class="btn btn-outline-primary">Reply</button>
                <a href="javascript::void(0);" class="btn btn-outline-secondary" onclick="reply_close(this)">Close</a>
            </form>
        </div>
        <!-- Reply Text Box Ends -->
    </div>
    <!-- Comment & Reply System Ends from Here -->

    <!-- subscribe section -->
    @include('home.subscribe')
    <!-- end subscribe section -->
    <!-- client section -->
    @include('home.client')
    <!-- end client section -->
    <!-- footer start -->
    @include('home.footer')
    <!-- footer end -->
    <div class="cpy_">
        <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

        </p>
    </div>

    <script type="text/javascript">
        function reply(caller) {
            document.getElementById('commentId').value = $(caller).attr('data-Commentid');


            $('.replyDiv').insertAfter($(caller));
            $('.replyDiv').show();
        }

        function reply_close(caller) {
            $('.replyDiv').hide();
        }
    </script>

    <!-- Refresh Page and Keep Scroll Position Starts -->
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>

    <!-- Refresh Page and Keep Scroll Position Endss -->

    <!-- jQery -->
    <script src="home/js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="home/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="home/js/bootstrap.js"></script>
    <!-- custom js -->
    <script src="home/js/custom.js"></script>
</body>

</html>
