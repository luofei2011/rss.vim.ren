<section class="seach">
    <h1>
        <form action="<?php echo BASE_URL . '?c=auth&f=search';?>">
            <input type="text"  name="kw" id="kw" placeholder="关键字">
            <i class="seach-btn" id="searchSubmit"></i>
        </form>
    </h1>
    <div id="searchResponse">
    </div>
</section>
<img src="./static/img/loadding.png" height="64" width="64" class="loading">
<script src="http://cdn.staticfile.org/zepto/1.0rc1/zepto.min.js"></script>
<script src="./static/js/app.js"></script>
<script>
$(function () {
    var $kw = $('#kw');
    var $loadimg = $(".loading")
    var $response = $('#searchResponse');

    $('#searchSubmit').on('click', function () {
        var $form = $(this).closest('form');
        var url = $form.attr('action');
        var kw = $kw.val();

        if (!kw) return false;

        $form[0].reset();

        $.ajax({
            url: url,
            type: 'get',
            data: {kw: kw},
            beforeSend:function(){
                $loadimg.css("display","block")
            },
            success: function (data) {
                $loadimg.css("display","none")
                data = JSON.parse(data);

                var html = "";

                if (data.status === 200) {
                    var list = data.data;
                    if (Object.prototype.toString.call(list) === '[object Object]') {
                        list = [list];
                    }

                    for (var i = 0, len = list.length; i < len; i++) {
                        html += '<article class="item"><h3>' +
                            '<a href="' + list[i].url + '">' + list[i].title + '</a></h3>' +
                            '<p class="descript">' + list[i].date + '</p>' +
                            '<p class="label">标签：' + list[i].tags + '</p>' +
                            '<p class="descript">描述：' + list[i].description + '</p>' +
                            '</article>';
                    }
                } else if (data.status === 302) {
                    RSS.router(data.url);
                }
                $response.html(html);
                $kw.val('');
            },
            error: function () {
            }
        });

        return false;
    });
});
</script>
