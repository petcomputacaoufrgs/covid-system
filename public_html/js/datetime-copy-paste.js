const ctrlKey = 17,
        cmdKey = 91,
        vKey = 86,
        cKey = 67;
        
let ctrlDown = false;

function convertDateToDatetimeFormat(dateList) {
	//Formato aaaa-mm-ddThh:mm
    return dateList[2] + '-' + dateList[1] + '-' + 
    		dateList[0] + 'T' +'00:00';
}

function convertDateToDateFormat(dateList) {
    //Formato aaaa-mm-dd
    return dateList[2] + '-' + dateList[1] + '-' + dateList[0];
}

function isValidDate(dateText) {
	return dateText.replace(/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/g, "") === "";
}

function onPaste(e, el, type) {
	if (ctrlDown && e.keyCode == vKey) {
    	navigator.clipboard.readText().then(text => {
        		const dateText = text.trim();
                console.log(dateText);
                if (isValidDate(dateText)) {
                	let dateList = dateText.split("/");
                
                    if (dateList.length < 3) {
                        dateList = dateText.split("-");
                    }

                    if (dateList.length < 3) {
                        dateList = dateText.split(".");
                    }

                    if (dateList[2].length !== 4) {
                        dateList[2].substring(0,4);
                    }

                    if (dateList.length >= 3) {
                        let date;

                        if (type === 'datetime') {
                            date = 	 
                                convertDateToDatetimeFormat(dateList);
                        } else if (type === 'date') {
                            date = 
                                convertDateToDateFormat(dateList);
                        }

                        if (date) {
                            $(el).val(date); 
                        }
                    }
                }
            })
            ctrlDown = false;
        } else if (e.keyCode == ctrlKey) {
            ctrlDown = true;
        }
}

function onCopy(e, el, type) {
	if (ctrlDown && e.keyCode == cKey) {
    	let text, textList;
        let inputText = $(el).val();
        
        if(type === 'datetime') {
            //Formato aaaa-mm-ddThh:mm
        	textList = inputText.replace('T', '-')
            					.replace(':', '-')
                                .split('-');
            
            text = textList[1] + '/' + 
            		textList[2] + '/' + 
                    textList[0] + ', ' +
                    textList[3] + ':' +
                    textList[4]
                    
        } else if (type === 'date') {
        	//Formato aaaa-mm-dd
            textList = inputText.split('-');
                  text = textList[1] + '/' + 
            		textList[2] + '/' + 
                    textList[0]
        }
        
        if (text) {
        	navigator.clipboard.writeText(text)
        }
    	
       	ctrlDown = false;
    } else if (e.keyCode == ctrlKey) {
        ctrlDown = true;
    }
}

function createPasteEvent(el, type) {
	$(el).keydown(e => onPaste(e, el, type));
}

function createCopyEvent(el, type) {
	$(el).keydown(e => onCopy(e, el, type));
}

$(document).ready(function() {   
    let dateInputs = document.querySelectorAll('[type="datetime-local"]');
        
    dateInputs.forEach(el => createPasteEvent(el, 'datetime'));
    dateInputs.forEach(el => createCopyEvent(el, 'datetime')); 
    
    dateInputs = document.querySelectorAll('[type="date"]');
    
    dateInputs.forEach(el => createPasteEvent(el, 'date'));
    dateInputs.forEach(el => createCopyEvent(el, 'date'));
});
