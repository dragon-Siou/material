$(function() {
    //onFollow();
    //onFollowing();
});

function onFollow() {
    $(".followContainer").delegate(".follow", "click", function() {
        //事件委託，如果圖片是追蹤時，會把圖片換成追蹤中
        $(this).addClass("following");
        $(this).removeClass("follow");
        $(this).prop("src", "images/following.png")
    });
}

function onFollowing() {

    $(".followContainer").delegate(".following", "click", function() {
        //事件委託，如果圖片是追蹤中時，會把圖片換成追蹤
        $(this).addClass("follow");
        $(this).removeClass("following");
        swal("取消追蹤?");
        $(this).prop("src", "images/follow.png");
    });
}