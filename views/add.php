<section class="add">
    <h1>添加记录</h1>
    <form action="<?php echo BASE_URL . '?c=auth&f=add';?>" method="post">
        <div>
            <input type="text" name="title" id="blogTitle" placeholder="地址名称、后序这里可能会改成自动抓取" data-required="required">
        </div>
        <div>
            <input type="text" name="url" id="blogUrl" placeholder="博客地址">
        </div>
        <div>
            <input type="text" name="tags" id="blogTags" placeholder="标签。请已';'分割多个标签">
        </div>
        <div>
            <textarea id="blogDes" name="description" cols="30" rows="10" placeholder="基于该地址的描述、便于以后翻阅"></textarea>
        </div>
        <div class="add-btn-group">
            <input type="submit" value="提交" id="addSubmit">
            <input type="reset" value="重置">
        </div>
    </form>
</section>
<img src="./static/img/loadding.png" height="64" width="64" class="loading">
<script src="http://cdn.staticfile.org/zepto/1.0rc1/zepto.min.js"></script>
<script src="./static/js/app.js"></script>
<script>
$(function () {
    var $addBtn = $('#addSubmit');
    var $loadimg = $(".loading")

    $('form').on('submit', function () {
        $addBtn.trigger('click');
        return false;
    });

    $addBtn.on('click', function (event) {
        var $form = $(this).closest('form');
        var url = $form.attr('action');
        var formRow = RSS.autoValidateAndCollect($form);
        if (formRow) {
            $.ajax({
                url: url,
                type: 'post',
                data: formRow,
                beforeSend:function(){
                    $loadimg.css("display","block")
                },
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.status === 200) {
                        if (data.msg == 'success') {
                            alert('添加成功！');
                            $form[0].reset();
                        } else {
                            alert('添加失败,再来一次。');
                        }
                        $loadimg.css("display","none");
                    } else if (data.status === 302) {
                        RSS.router(data.url);
                    }
                },
                error: function () {
                },
                always: function () {
                    $loadimg.css("display","none");
                }
            });
        }
        return false;
    });
});
</script>
