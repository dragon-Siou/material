$(function() {
    editFileInClick();
    chPasswd();
    recordInCliCk();
    radioInEditPage();
    initialize();
    uploadBigHeadNameChange();
});

function initialize(){
    var me = document.getElementById("t1");
    var meForm = document.getElementById("editProfileForm");
    var a1 = document.getElementById("t2");
    var a2 = document.getElementById("t3");
    me.style.width = "620px";
    me.style.height = "480px";
    me.style.display = "block";
    meForm.style.display = "inline-block";
    meForm.style.widows = "440px";
    meForm.style.height = "300px";
    a1.style.width = "0px";
    a1.style.height = "0px";
    a1.style.display = "none";
    a2.style.width = "0px";
    a2.style.height = "0px";
    a2.style.display = "none";
}

function editFileInClick() {
    $("#editFile").click(function() {
        var me = document.getElementById("t1");
        var meForm = document.getElementById("editProfileForm");
        var a1 = document.getElementById("t2");
        var a2 = document.getElementById("t3");
        me.style.width = "620px";
        me.style.height = "480px";
        me.style.display = "block";
        meForm.style.display = "inline-block";
        meForm.style.widows = "440px";
        meForm.style.height = "300px";
        a1.style.width = "0px";
        a1.style.height = "0px";
        a1.style.display = "none";
        a2.style.width = "0px";
        a2.style.height = "0px";
        a2.style.display = "none";
    });
}

function chPasswd() {
    $("#chPasswd").click(function() {
        var me = document.getElementById("t2");
        var meForm = document.getElementById("editPasswordForm");
        var a1 = document.getElementById("t1");
        var a2 = document.getElementById("t3");
        me.style.width = "620px";
        me.style.height = "480px";
        me.style.display = "block";
        meForm.style.display = "inline-block";
        meForm.style.widows = "440px";
        meForm.style.height = "300px";
        a1.style.width = "0px";
        a1.style.height = "0px";
        a1.style.display = "none";
        a2.style.width = "0px";
        a2.style.height = "0px";
        a2.style.display = "none";
    });
}

function recordInCliCk() {
    $("#record").click(function() {
        var me = document.getElementById("t3");
        var a1 = document.getElementById("t1");
        var a2 = document.getElementById("t2");
        me.style.width = "620px";
        me.style.height = "480px";
        me.style.display = "block";
        a1.style.width = "0px";
        a1.style.height = "0px";
        a1.style.display = "none";
        a2.style.width = "0px";
        a2.style.height = "0px";
        a2.style.display = "none";
    });
}

function radioInEditPage() {
    $(".radioInEditPage").click(function() {
        $(this).parent().addClass("clickInEdit").parent().siblings().children().removeClass("clickInEdit");
    });
}

function uploadBigHeadNameChange() {
    $("#file-upload").change(function() {
        $("#uploadFileName").html($("#file-upload").val());
    });
}