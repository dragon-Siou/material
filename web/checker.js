$(function() {
    clickGood();
});

function clickGood() {
    $(".goodInfo").click(function() {
        var a = $(this).parent().css("background-image");
        var b = a.slice(a.lastIndexOf("/") + 1, a.lastIndexOf("."));
        if (b == "emptyGood") {
            $(this).parent().addClass("fullGoodJs");
        } else {
            $(this).parent().removeClass("fullGoodJs");
        }
    });
}