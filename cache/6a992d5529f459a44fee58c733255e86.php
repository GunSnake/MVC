<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" >
    <title>我的留言板</title>
    
    <link rel='stylesheet' href='public/css/bootstrap.min.css'>
    <script type='text/javascript' src='public/js/jquery-2.1.0.min.js'></script>
    <script type='text/javascript' src='public/js/bootstrap.min.js'></script>

    <script type='text/javascript' src='public/js/jquery.swipebox.js'></script>
    <link rel="stylesheet" href="public/css/swipebox.css">

    <style type="text/css">
        .jumbotron{
            margin-top: 70px;
            height: 35%;
            text-align: center;
        }
    </style>
    <script>
        $(function(){
            $('#swipebox').click(function(e){
                e.preventDefault();
                $.swipebox([
                    {href:'public/images/Desert.jpg',title:'images1'},
                    {href:'public/images/Lighthouse.jpg',title:'images2'}
                ],{
                    loopAtEnd : true,
                });
            });
            var num = 2;
            $(".jumbotron>p>a").click(function(){
                var click_text = $(this).text();
                if (click_text.indexOf('QvQ') != -1){
                    $(this).text('我要消失啦~');
                    $(this).animate({marginRight:'-200px',opacity: 0},1500,'linear',function(){
                        $(this).hide();
                    });
                }else{
                    $(this).text('我要消失啦~');
                    $(this).animate({marginLeft:'-200px',opacity: 0},1500,'swing',function(){
                        $(this).hide();
                    });
                }
                num--;
                if(num == 0){
                    $('.jumbotron>p>a:nth-child(3)').show();
                }
            });
            $('.jumbotron>p>a:nth-child(3)').click(function(){
               $('.jumbotron').hide();
            });
        });
    </script>
</head>
<body>
<div id="index_head"></div>
<script>$(function(){$("#index_head").load('./View/template/header.html')});</script>
<div class="jumbotron">
    <h2>这是一个个人技术网站<br /> 不一定会放什么上去<br /> JUST FOR FUN</h2>
    <p>_(:з」∠)_</p>
    <p>
        <a class="btn btn-info btn-lg" href="#" role="button">点我点我</a>
        <a class="btn btn-warning btn-lg" href="#" role="button">我也要QvQ</a>
        <a class="btn btn-success btn-lg" href="#" role="button" style="display: none;">点我消失</a>
    </p>
</div>
<div class="menu-title">

</div>
<div class="main-containter">

</div>
<div>
    <iframe src="View/template/footer.html" frameborder="0"  scrolling="no"></iframe>
</div>
</body>
</html>