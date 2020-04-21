const dateType = 'date',
		dateTimeType = 'datetime-local';

const ctrlKey = 'Control',
        cmdKey = 'Meta',
        vKey = 'v',
        cKey = 'c';
        
let ctrlDown = false;

function canReadClipboard() {
	return Boolean(navigator && navigator.clipboard && navigator.clipboard.readText);
}

function canWriteClipboard() {
	return Boolean(navigator && navigator.clipboard && navigator.clipboard.writeText);
}

function isControl(key) {
	return (key === ctrlKey || key === cmdKey)
}

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
	if (ctrlDown && e.key == vKey) {
    	navigator.clipboard.readText().then(text => {
        		const dateText = text.trim().substring(0,10);
                if (isValidDate(dateText)) {
                	let dateList = dateText.split("/");
                
                    if (dateList.length < 3) {
                        dateList = dateText.split("-");
                    }

                    if (dateList.length < 3) {
                        dateList = dateText.split(".");
                    }

                    if (dateList[2].length !== 4) {
                         dateList[2] = dateList[2].substring(0,4);
                    }

                    if (dateList.length >= 3) {
                        let date;

                        if (type === dateTimeType) {
                            date = 	 
                                convertDateToDatetimeFormat(dateList);
                        } else if (type === dateType) {
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
        } else if (isControl(e.key)) {
            ctrlDown = true;
        }
}

function onCopy(e, el, type) {
	if (ctrlDown && e.key == cKey) {
    	let text, textList;
        let inputText = $(el).val();
        
        if(type === dateTimeType) {
            //Formato aaaa-mm-ddThh:mm
        	textList = inputText.replace('T', '-')
            					.replace(':', '-')
                                .split('-');
            
            text = textList[2] + '/' + 
            		textList[1] + '/' + 
                    textList[0] + ', ' +
                    textList[3] + ':' +
                    textList[4]
                    
        } else if (type === dateType) {
        	//Formato aaaa-mm-dd
            textList = inputText.split('-');
                  text = textList[2] + '/' + 
            		textList[1] + '/' + 
                    textList[0]
        }
        
        if (text) {
        	navigator.clipboard.writeText(text)
        }
    	
       	ctrlDown = false;
    } else if (isControl(e.key)) {
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
    let dateInputs = document.querySelectorAll('[type="'+dateTimeType+'"]');
    
    const canRead = canReadClipboard();
    const canWrite = canWriteClipboard();
    
    if (canRead) {
    	dateInputs.forEach(el => createPasteEvent(el, dateTimeType));
    }
    
    if (canWrite) {
        dateInputs.forEach(el => createCopyEvent(el, dateTimeType)); 
    }    
    
    dateInputs = document.querySelectorAll('[type="'+dateType+'"]');
    type = 'date'
    
    if (canRead) {
    	dateInputs.forEach(el => createPasteEvent(el, dateType));
    }
    
    if (canWrite) {
        dateInputs.forEach(el => createCopyEvent(el, dateType));
    }  
    
});
