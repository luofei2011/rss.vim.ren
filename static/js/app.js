var RSS = {};

RSS.autoValidateAndCollect = function (node) {
    var items = node.find('input, textarea, select');
    var checked = true;
    var collect = {};

    items.each(function () {
        var $this = $(this);
        var value = $.trim($this.val());

        if (this.name) {
            if ($this.data('required') && !value) {
                alert(this.name + ' is required!')
                checked = false;
                return false;
            }

            collect[this.name] = value;
        }
    });

    return checked && collect;
}

RSS.router = function (url) {
    var a = document.createElement('a');
    a.href = url;

    window.location.href = a.href;
}
