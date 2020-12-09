$(function(){
    $("#registeredButton").click(checkData);
});



function checkData(){
    //alert("空的");
    
    let form = $("#memberForm").get(0);
    let formData=new FormData(form);
    //alert("空的");
    let memberDataChecking = new MemberDataChecking();
    
    memberDataChecking.account = formData.get("account");
    memberDataChecking.userName = formData.get("userName");
    memberDataChecking.password = formData.get("password");
    memberDataChecking.confirmPassword = formData.get("confirmPassword");
    
    memberDataChecking.chechAccount();
    memberDataChecking.checkUserName();
    memberDataChecking.checkPassword();
    memberDataChecking.checkConfirmPassword();

    if(memberDataChecking.isDataCorrect){
        //提交
        $("#memberForm").submit();
    }
}