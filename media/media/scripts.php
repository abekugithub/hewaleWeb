<script>
$(document).ready(function(){
	//to allow only numbers
	if($('.onlynums')){
		$('.onlynums').keydown(function(event)
        {

		 // Allow: backspace, delete, tab, escape, and enter

		 if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || event.keyCode == 190 || event.keyCode == 110 || event.keyCode == 173) {
                 // let it happen, don't do anything
                 return;
        }else{
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
		}

		});

		}
	});

	function clicktoPrint(){
	try{
		if (CheckIsIE() == true){
		iframe = document.getElementById('printframe');
        iframe.contentWindow.document.execCommand('print', false, null);
		}else{
			window.printframe.focus();
                window.printframe.print();
					}
            }catch(e){
				window.printframe.focus();
                window.printframe.print();
            }
	}
</script>