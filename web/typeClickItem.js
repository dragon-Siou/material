$(function() {
    typeItemClick();
})

function typeItemClick() {
    $(".typelistItem").click(function() {
        $(this).addClass("typelistInClick").siblings().removeClass("typelistInClick");
    });
}