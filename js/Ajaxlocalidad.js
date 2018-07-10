var XmlHttpObj;

var Utf8 = {

    //Convierte de UTF-8 a ISO
    decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while ( i < utftext.length ) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}

function CreateXmlHttpObj(){
	try{
		XmlHttpObj = new ActiveXObject("Msxml2.XMLHTTP");
	
	}catch(e){
		try{
			XmlHttpObj = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(oc){
			XmlHttpObj = null;
		}
	}
		if(!XmlHttpObj && typeof XMLHttpRequest != "undefined") {
		XmlHttpObj = new XMLHttpRequest();
	}
}


function provinciaListOnChange() {
	
	//limpio combo localidades
	var localidadList = document.getElementById("localidadList");
	for (var count = localidadList.options.length-1; count >-1; count--){
		localidadList.options[count] = null;
	}
	
	var to=document.getElementById("advice");
	to.innerHTML="<img src='images/loading.gif' align='absmiddle'>";
    var localidadList = document.getElementById("localidadesList");
 
    var selectedprovincia = provinciaList.options[provinciaList.selectedIndex].value;
	
    var requestUrl;

    requestUrl = "xml_data_providelocalidad.php" + "?filter=" + encodeURIComponent(selectedprovincia);
    
	CreateXmlHttpObj();
	
	if(XmlHttpObj){
	
		XmlHttpObj.onreadystatechange = StateChangeHandler;
		XmlHttpObj.open( "POST", requestUrl, true );
		XmlHttpObj.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		XmlHttpObj.send('');		
	}
}


function StateChangeHandler(){	
	if(XmlHttpObj.readyState == 4){
		if(XmlHttpObj.status == 200){			
			PopulatelocalidadList(XmlHttpObj.responseXML.documentElement);
		}else{
			alert("C�digo de error: "  + XmlHttpObj.status);
		}
	}
}


function PopulatelocalidadList(localidadNode){	
    
	var localidadNodes = localidadNode.getElementsByTagName('nombre');
	var idlocalidadesNodes = localidadNode.getElementsByTagName('id');
	var textValue; 
	var idValue;
	var optionItem;
	
	for (var count = 0; count < localidadNodes.length; count++){ 
   		textValue = GetInnerText(localidadNodes[count]);
		idValue=GetInnerText(idlocalidadesNodes[count]);
		optionItem = new Option(textValue, idValue,  false, false);
		document.form.localidadList.options[document.form.localidadList.length] = optionItem;
	}
var to=document.getElementById("advice");
to.innerHTML="";
}

function GetInnerText (node){
	 return (node.textContent || node.innerText || node.text) ;
}