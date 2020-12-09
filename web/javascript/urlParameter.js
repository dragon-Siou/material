class UrlParameter{
    url;
    data;

    constructor(url){
        
        this.url=url;
        this.data=new Array();
        
        if(url.indexOf("?")!=-1){
            
            let arr = this.url.split("?")[1].split("#")[0].split("&");
            //alert(this.url.split("?")[1].split("&")[0]);
            for(let parameter of arr){
                //alert(parameter);
                let element=parameter.split("=");
                this.data[element[0]]=element[1];
            }
        }
        
    }

    hasKey(key){
        if( this.data[key] === undefined){
            return false;
        }
        return true;
    }

}



