<section class="search">
    <h1>
        <form action="<?php echo BASE_URL . '?c=auth&f=search';?>" method="get">
            <input type="text"  name="kw" id="kw" placeholder="关键字">
            <i class="search-btn" id="searchSubmit"></i>
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

    // 判断是否支持touch事件
    try {
        document.createEvent('TouchEvent');
        $('.search').addClass('mobile');
    } catch(e) {
    }

    $response.on('touchstart', 'article.item', function () {
        var $this = $(this);
        var $deleteBtn = $this.find('a.delete-btn');

        $deleteBtn.show();
    });

    $response.on('click', 'article.item a.delete-btn', function (e) {
        var $this = $(this);
        var id = $this.data('id');
        var $searchItem = $this.closest('article.item');

        $loadimg.show();

        $.ajax({
            type: 'post',
            data: {id: id},
            url: '<?php echo BASE_URL;?>' + '?c=auth&f=del_rss',
            success: function (data) {
                $loadimg.hide();

                $searchItem.remove();
            },
            error: function () {
                $loadimg.hide();
            }
        });

        e.preventDefault();
        return false;
    });
    $('form').on('submit', function () {
        $('#searchSubmit').trigger('click');
        return false;
    });

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
                            '<a href="javascript:void(0);" class="delete-btn" data-id="' + list[i].id + '"></a>' +
                            '<a href="/?f=add&isupdate=1&id=' + list[i].id + '" class="edit-btn" target="_self"></a>' +
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
