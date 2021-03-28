require('./bootstrap');

let timeout_id = null;

$("body").on("input", ".js-content", function(){
    if(timeout_id){
        clearTimeout(timeout_id);
    }

    timeout_id = setTimeout(save_content, 500);
});

$("body").on("click", ".js-link-copy", function(){
    const btn = $(this),
        link = btn.data("link");

    if(link){
        var copytext = document.createElement('input');
        copytext.value = link;
        document.body.appendChild(copytext);
        copytext.select();
        document.execCommand('copy');
        document.body.removeChild(copytext);

        let btn_text = btn.text();
        btn.text("Copied!");
        setTimeout(function(){
            btn.text(btn_text);
        }, 1000);
    }
});

$("body").on("click", ".js-select-all", function(){
    selectElementContents(document.getElementById("content_view"));
});

$(".js-content").keydown(function(e) {
    if (e.key == 'Tab') {
        var start = this.selectionStart;
        var end = this.selectionEnd;

        var $this = $(this);
        var value = $this.val();

        $this.val(value.substring(0, start)
            + "\t"
            + value.substring(end));

        this.selectionStart = this.selectionEnd = start + 1;

        e.preventDefault();
    }
});


function save_content(){
    const field = $(".js-content"),
        form = field.closest("form");

    $.ajax({
        type: "POST",
        url: form.attr("action"),
        global: false,
        cache: false,
        data: form.serialize(),
    });
}

function selectElementContents(el) {
    let range = document.createRange();
    range.selectNodeContents(el);
    let sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
}