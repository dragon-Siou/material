$(function() {
    uploadFileInMES();
})

function uploadFileInMES() {
    $("#sentPic").change(function() {
        $("#uploadFileName").html($("#sentPic").val());
    });
}