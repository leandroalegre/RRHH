var XmlHttpObj2;

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

function CreateXmlHttpObj2(){
	try{
		XmlHttpObj2 = new ActiveXObject("Msxml2.XMLHTTP");
	
	}catch(e){
		try{
			XmlHttpObj2 = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(oc){
			XmlHttpObj2 = null;
		}
	}
		if(!XmlHttpObj2 && typeof XMLHttpRequest != "undefined") {
		XmlHttpObj2 = new XMLHttpRequest();
	}
}


function personalsaludListOnChange() {
	
	//limpio combo localidades
	var disciplinapersonalList = document.getElementById("disciplinapersonalList");
	for (var count = disciplinapersonalList.options.length-1; count >-1; count--){
		disciplinapersonalList.options[count] = null;
	}
	
	var to=document.getElementById("advice");
	to.innerHTML="<img src='images/loading.gif' align='absmiddle'>";
    var disciplinapersonalList = document.getElementById("disciplinapersonalList");
 
    var selectedtipopersonal = personalsaludList.options[personalsaludList.selectedIndex].value;
	
    var requestUrl2;

    requestUrl2 = "xml_data_providedisciplinas.php" + "?filterd=" + encodeURIComponent(selectedtipopersonal);
    
	CreateXmlHttpObj2();
	
	if(XmlHttpObj2){
	
		XmlHttpObj2.onreadystatechange = StateChangeHandler2;
		XmlHttpObj2.open( "POST", requestUrl2, true );
		XmlHttpObj2.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		XmlHttpObj2.send('');		
	}
}


function StateChangeHandler2(){	
	if(XmlHttpObj2.readyState == 4){
		if(XmlHttpObj2.status == 200){			
			PopulatedisciplinaList(XmlHttpObj2.responseXML.documentElement);
		}else{
			alert("Código de error: "  + XmlHttpObj2.status);
		}
	}
}


function PopulatedisciplinaList(DisciplinaNode){
	var disciplinaNodes = DisciplinaNode.getElementsByTagName('nombre');
	var iddisciplinaNodes = DisciplinaNode.getElementsByTagName('id');

	var textValue; 
	var idValue;
	var optionItem;

	idValue=idValue2=GetInnerText2(iddisciplinaNodes[0]);
	console.log(idValue);
	if(idValue=="-1"){
		document.getElementById("displaydisciplinapersonalList").style.display="none";
	}else{
		document.getElementById("displaydisciplinapersonalList").style.display="table-row";
	}



	
	for (var count = 0; count < disciplinaNodes.length; count++){ 
   		textValue2 = GetInnerText2(disciplinaNodes[count]);
		idValue2=GetInnerText2(iddisciplinaNodes[count]);
		optionItem2= new Option(textValue2, idValue2,  false, false);
		document.form.disciplinapersonalList.options[document.form.disciplinapersonalList.length] = optionItem2;
	}
var to=document.getElementById("advice");
to.innerHTML="";
}

function GetInnerText2 (node){
	 return (node.textContent || node.innerText || node.text) ;
}