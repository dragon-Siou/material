$(function() {
    displayPriceInput();
    hidePriceInput();
    uploadFileNameChange();
});



function displayPriceInput() {
    $("#productRadio").click(function() {
        var a = document.getElementById("priceBlock");
        a.style.display = "block";
    });
}



function hidePriceInput() {
    $("#galleryRadio,#commissionRadio").click(function() {
        var a = document.getElementById("priceBlock");
        a.style.display = "none";
    });
}



function uploadFileNameChange() {
    $("#file-upload1").change(function() {
        $("#uploadFileName2").html($("#file-upload1").val());
    });
}